<?php

namespace App\Http\Controllers;

use App\Models\Lietotajs;
use App\Models\Pasakumi;
use App\Models\PasakumiImage;
use App\Models\PasakumuAtsauksme;
use App\Models\PasakumuPieteikums;
use App\Models\Telpa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PasakumuController extends Controller
{
    public function index()
    {
        $data = Pasakumi::with([
            'images',
            'darbinieks',
            'telpa',
            'aktiviePieteikumi'
        ])->orderBy('ID', 'desc')->get();

        return view('alldata', compact('data'));
    }

    public function create()
    {
        $darbinieki = Lietotajs::whereIn('loma', ['Admin', 'Darbinieks'])
            ->where('aktivs', 1)
            ->orderBy('vards')
            ->orderBy('uzvards')
            ->get();

        $telpas = Telpa::orderBy('nosaukums')->get(['ID', 'nosaukums', 'ietilpiba']);
        $aiznemtieLaiki = $this->aiznemtieResursuLaiki();

        return view('create', compact('darbinieki', 'telpas', 'aiznemtieLaiki'));
    }

    public function availableRooms(Request $request)
    {
        $validated = $request->validate([
            'datums_no' => 'required|date',
            'datums_lidz' => 'required|date|after_or_equal:datums_no',
            'sakuma_laiks' => 'required|date_format:H:i',
            'beigu_laiks' => 'required|date_format:H:i|after:sakuma_laiks',
            'ignore_id' => 'nullable|integer|exists:pasakumi,ID',
        ]);

        return response()->json([
            'telpas' => $this->pieejamasTelpas(
                $validated['datums_no'],
                $validated['datums_lidz'],
                $validated['sakuma_laiks'],
                $validated['beigu_laiks'],
                $validated['ignore_id'] ?? null
            )->values(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nosaukums' => 'required|max:45',
            'kategorija' => 'required|max:45',
            'datums_no' => 'required|date',
            'datums_lidz' => 'required|date|after_or_equal:datums_no',
            'sakuma_laiks' => 'required|date_format:H:i',
            'beigu_laiks' => 'required|date_format:H:i|after:sakuma_laiks',
            'apraksts' => 'nullable|max:255',
            'darbinieks_id' => 'required|exists:lietotaji,ID',
            'telpa_id' => 'required|exists:telpa,ID',
            'registracijas_beigu_datums' => 'nullable|date|required_with:registracijas_beigu_laiks',
            'registracijas_beigu_laiks' => 'nullable|date_format:H:i|required_with:registracijas_beigu_datums',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->parbauditTelpu(
            $validated['telpa_id'],
            $validated['datums_no'],
            $validated['datums_lidz'],
            $validated['sakuma_laiks'],
            $validated['beigu_laiks']
        );

        $this->parbauditDarbinieku(
            $validated['darbinieks_id'],
            $validated['datums_no'],
            $validated['datums_lidz'],
            $validated['sakuma_laiks'],
            $validated['beigu_laiks']
        );

        $pasakums = Pasakumi::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('pasakumi', 'public');

                PasakumiImage::create([
                    'pasakumi_id' => $pasakums->ID,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('pasakumi.index')->with('success', 'Pasākums pievienots.');
    }

    public function show($id)
    {
        $data = Pasakumi::with([
            'images',
            'darbinieks',
            'telpa',
            'atsauksmes.lietotajs',
            'aktiviePieteikumi.lietotajs'
        ])->findOrFail($id);

        $lietotajaPieteikums = null;
        $varPieteikties = false;
        $varAtstatAtsauksmi = false;
        $pieteiksanasInfo = $this->pieteiksanasInfo(null, $data);

        if (auth()->check()) {
            $lietotajaPieteikums = PasakumuPieteikums::where('pasakums_id', $data->ID)
                ->where('lietotajs_id', auth()->id())
                ->first();

            $pieteiksanasInfo = $this->pieteiksanasInfo(auth()->user(), $data, $lietotajaPieteikums);
            $varPieteikties = $pieteiksanasInfo['varPieteikties'];
            $varAtstatAtsauksmi = $this->varAtstatAtsauksmi(auth()->user(), $data);
        }

        return view('details', compact(
            'data',
            'lietotajaPieteikums',
            'varPieteikties',
            'pieteiksanasInfo',
            'varAtstatAtsauksmi'
        ));
    }

    public function edit($id)
    {
        $item = Pasakumi::with('images')->findOrFail($id);

        $darbinieki = Lietotajs::whereIn('loma', ['Admin', 'Darbinieks'])
            ->where('aktivs', 1)
            ->orderBy('vards')
            ->orderBy('uzvards')
            ->get();

        $telpas = Telpa::orderBy('nosaukums')->get(['ID', 'nosaukums', 'ietilpiba']);
        $aiznemtieLaiki = $this->aiznemtieResursuLaiki($id);

        return view('edit', compact('item', 'darbinieki', 'telpas', 'aiznemtieLaiki'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nosaukums' => 'required|max:45',
            'kategorija' => 'required|max:45',
            'datums_no' => 'required|date',
            'datums_lidz' => 'required|date|after_or_equal:datums_no',
            'sakuma_laiks' => 'required|date_format:H:i',
            'beigu_laiks' => 'required|date_format:H:i|after:sakuma_laiks',
            'apraksts' => 'nullable|max:255',
            'darbinieks_id' => 'required|exists:lietotaji,ID',
            'telpa_id' => 'required|exists:telpa,ID',
            'registracijas_beigu_datums' => 'nullable|date|required_with:registracijas_beigu_laiks',
            'registracijas_beigu_laiks' => 'nullable|date_format:H:i|required_with:registracijas_beigu_datums',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->parbauditTelpu(
            $validated['telpa_id'],
            $validated['datums_no'],
            $validated['datums_lidz'],
            $validated['sakuma_laiks'],
            $validated['beigu_laiks'],
            $id
        );

        $this->parbauditDarbinieku(
            $validated['darbinieks_id'],
            $validated['datums_no'],
            $validated['datums_lidz'],
            $validated['sakuma_laiks'],
            $validated['beigu_laiks'],
            $id
        );

        $item = Pasakumi::findOrFail($id);
        $item->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('pasakumi', 'public');

                PasakumiImage::create([
                    'pasakumi_id' => $item->ID,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('pasakumi.index')->with('success', 'Pasākums atjaunināts.');
    }

    public function destroy($id)
    {
        $item = Pasakumi::with('images')->findOrFail($id);

        foreach ($item->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $item->delete();

        return redirect()->route('pasakumi.index')->with('success', 'Pasākums dzēsts.');
    }

    public function deleteImage($pasakumiId, $imageId)
    {
        $image = PasakumiImage::where('pasakumi_id', $pasakumiId)
            ->where('id', $imageId)
            ->firstOrFail();

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Attēls dzēsts.');
    }

    public function pieteikties($id)
    {
        $lietotajs = auth()->user();
        $pasakums = Pasakumi::with('telpa', 'aktiviePieteikumi')->findOrFail($id);

        $esošais = PasakumuPieteikums::where('pasakums_id', $id)
            ->where('lietotajs_id', $lietotajs->ID)
            ->first();

        $pieteiksanasInfo = $this->pieteiksanasInfo($lietotajs, $pasakums, $esošais);

        if (!$pieteiksanasInfo['varPieteikties']) {
            return back()->withErrors([
                'pieteiksanas' => $pieteiksanasInfo['iemesls'],
            ]);
        }

        PasakumuPieteikums::create([
            'pasakums_id' => $id,
            'lietotajs_id' => $lietotajs->ID,
            'statuss' => 'Pieteikts',
        ]);

        return back()->with('success', 'Jūs veiksmīgi pieteicāties pasākumam.');
    }

    public function atzimetApmekletu($pasakumsId, $lietotajsId)
    {
        $pieteikums = PasakumuPieteikums::where('pasakums_id', $pasakumsId)
            ->where('lietotajs_id', $lietotajsId)
            ->firstOrFail();

        $pieteikums->statuss = 'Apmeklets';
        $pieteikums->apmeklets_at = now();
        $pieteikums->save();

        return back()->with('success', 'Apmeklējums atzīmēts.');
    }

    public function saglabatAtsauksmi(Request $request, $id)
    {
        $validated = $request->validate([
            'vertejums' => 'required|integer|min:1|max:5',
            'atsauksme' => 'nullable|string|max:1000',
        ]);

        $pasakums = Pasakumi::findOrFail($id);

        if (!$this->varAtstatAtsauksmi(auth()->user(), $pasakums)) {
            return back()->withErrors([
                'atsauksme' => 'Atsauksmi var atstāt tikai lietotājs, kurš apmeklēja pasākumu.',
            ]);
        }

        PasakumuAtsauksme::updateOrCreate(
            [
                'pasakums_id' => $id,
                'lietotajs_id' => auth()->id(),
            ],
            [
                'vertejums' => $validated['vertejums'],
                'atsauksme' => $validated['atsauksme'],
                'izveidots_at' => now(),
            ]
        );

        return back()->with('success', 'Atsauksme saglabāta.');
    }

    private function parbauditTelpu($telpaId, $datumsNo, $datumsLidz, $sakumaLaiks, $beiguLaiks, $ignoreId = null)
    {
        // Saglabāšanas brīdī vēlreiz pārbauda, vai lietotājs nav izvēlējies aizņemtu telpu.
        $telpaPieejama = $this->pieejamasTelpas($datumsNo, $datumsLidz, $sakumaLaiks, $beiguLaiks, $ignoreId)
            ->contains('ID', (int) $telpaId);

        if (!$telpaPieejama) {
            throw ValidationException::withMessages([
                'telpa_id' => 'Izvēlētā telpa šajā laikā nav brīva.',
            ]);
        }
    }

    private function parbauditDarbinieku($darbinieksId, $datumsNo, $datumsLidz, $sakumaLaiks, $beiguLaiks, $ignoreId = null)
    {
        // Darbinieks drīkst būt atbildīgais tikai tad, ja viņam nav cita pārklājoša pasākuma.
        $darbinieksPieejams = $this->pieejamieDarbinieki($datumsNo, $datumsLidz, $sakumaLaiks, $beiguLaiks, $ignoreId)
            ->contains('ID', (int) $darbinieksId);

        if (!$darbinieksPieejams) {
            throw ValidationException::withMessages([
                'darbinieks_id' => 'Izvēlētais darbinieks šajā laikā jau ir aizņemts.',
            ]);
        }
    }

    private function pieejamasTelpas($datumsNo, $datumsLidz, $sakumaLaiks, $beiguLaiks, $ignoreId = null)
    {
        // Aizņemtās telpas tiek iegūtas no pārklājošiem pasākumiem tajā pašā periodā.
        $aiznemtasTelpas = $this->parklajosiesPasakumi($datumsNo, $datumsLidz, $sakumaLaiks, $beiguLaiks, $ignoreId)
            ->pluck('telpa_id');

        return Telpa::query()
            ->whereNotIn('ID', $aiznemtasTelpas)
            ->orderBy('nosaukums')
            ->get(['ID', 'nosaukums', 'ietilpiba']);
    }

    private function pieejamieDarbinieki($datumsNo, $datumsLidz, $sakumaLaiks, $beiguLaiks, $ignoreId = null)
    {
        // Darbinieks ir pieejams, ja nav atrasts nevienā pārklājošā pasākumā.
        $aiznemtieDarbinieki = $this->parklajosiesPasakumi($datumsNo, $datumsLidz, $sakumaLaiks, $beiguLaiks, $ignoreId)
            ->pluck('darbinieks_id');

        return Lietotajs::query()
            ->whereIn('loma', ['Admin', 'Darbinieks'])
            ->where('aktivs', 1)
            ->whereNotIn('ID', $aiznemtieDarbinieki)
            ->orderBy('vards')
            ->orderBy('uzvards')
            ->get(['ID', 'vards', 'uzvards']);
    }

    private function aiznemtieResursuLaiki($ignoreId = null)
    {
        // Forma izmanto šo sarakstu, lai klienta pusē filtrētu telpas un darbiniekus.
        return Pasakumi::query()
            ->when($ignoreId, fn ($query) => $query->where('ID', '!=', $ignoreId))
            ->get(['telpa_id', 'darbinieks_id', 'datums_no', 'datums_lidz', 'sakuma_laiks', 'beigu_laiks']);
    }

    private function parklajosiesPasakumi($datumsNo, $datumsLidz, $sakumaLaiks, $beiguLaiks, $ignoreId = null)
    {
        // Pārklāšanās ir tad, ja sakrīt gan datumu intervāls, gan laika intervāls.
        return Pasakumi::query()
            ->when($ignoreId, fn ($query) => $query->where('ID', '!=', $ignoreId))
            ->where('datums_no', '<=', $datumsLidz)
            ->where('datums_lidz', '>=', $datumsNo)
            ->where('sakuma_laiks', '<', $beiguLaiks)
            ->where('beigu_laiks', '>', $sakumaLaiks)
            ->get(['telpa_id', 'darbinieks_id', 'datums_no', 'datums_lidz', 'sakuma_laiks', 'beigu_laiks']);
    }

    private function varPieteikties($lietotajs, $pasakums, $esosaisPieteikums = null): bool
    {
        return $this->pieteiksanasInfo($lietotajs, $pasakums, $esosaisPieteikums)['varPieteikties'];
    }

    private function pieteiksanasInfo($lietotajs, $pasakums, $esosaisPieteikums = null): array
    {
        $ietilpiba = (int) ($pasakums->telpa->ietilpiba ?? 0);
        $aiznemtasVietas = $pasakums->aktiviePieteikumi->count();
        $brivasVietas = $ietilpiba > 0 ? max($ietilpiba - $aiznemtasVietas, 0) : null;

        if (!$lietotajs) {
            return [
                'varPieteikties' => false,
                'iemesls' => 'Pieslēdzieties, lai pieteiktos pasākumam.',
                'aiznemtasVietas' => $aiznemtasVietas,
                'brivasVietas' => $brivasVietas,
                'ietilpiba' => $ietilpiba,
                'registracijasBeigas' => $this->registracijasBeigas($pasakums),
            ];
        }

        if (!$lietotajs->irApstiprinats()) {
            return [
                'varPieteikties' => false,
                'iemesls' => 'Tikai apstiprināts lietotājs var pieteikties pasākumam.',
                'aiznemtasVietas' => $aiznemtasVietas,
                'brivasVietas' => $brivasVietas,
                'ietilpiba' => $ietilpiba,
                'registracijasBeigas' => $this->registracijasBeigas($pasakums),
            ];
        }

        if ($lietotajs->loma !== 'Lietotajs') {
            return [
                'varPieteikties' => false,
                'iemesls' => 'Pasākumam var pieteikties tikai reģistrētie lietotāji.',
                'aiznemtasVietas' => $aiznemtasVietas,
                'brivasVietas' => $brivasVietas,
                'ietilpiba' => $ietilpiba,
                'registracijasBeigas' => $this->registracijasBeigas($pasakums),
            ];
        }

        if ($esosaisPieteikums) {
            return [
                'varPieteikties' => false,
                'iemesls' => 'Jūs šim pasākumam jau esat pieteicies.',
                'aiznemtasVietas' => $aiznemtasVietas,
                'brivasVietas' => $brivasVietas,
                'ietilpiba' => $ietilpiba,
                'registracijasBeigas' => $this->registracijasBeigas($pasakums),
            ];
        }

        $registracijasBeigas = $this->registracijasBeigas($pasakums);
        if ($registracijasBeigas && now()->gt($registracijasBeigas)) {
            return [
                'varPieteikties' => false,
                'iemesls' => 'Pieteikšanās termiņš šim pasākumam ir beidzies.',
                'aiznemtasVietas' => $aiznemtasVietas,
                'brivasVietas' => $brivasVietas,
                'ietilpiba' => $ietilpiba,
                'registracijasBeigas' => $registracijasBeigas,
            ];
        }

        if ($ietilpiba > 0 && $aiznemtasVietas >= $ietilpiba) {
            return [
                'varPieteikties' => false,
                'iemesls' => 'Brīvu vietu vairs nav.',
                'aiznemtasVietas' => $aiznemtasVietas,
                'brivasVietas' => 0,
                'ietilpiba' => $ietilpiba,
                'registracijasBeigas' => $registracijasBeigas,
            ];
        }

        return [
            'varPieteikties' => true,
            'iemesls' => null,
            'aiznemtasVietas' => $aiznemtasVietas,
            'brivasVietas' => $brivasVietas,
            'ietilpiba' => $ietilpiba,
            'registracijasBeigas' => $registracijasBeigas,
        ];
    }

    private function registracijasBeigas($pasakums): ?Carbon
    {
        if (!$pasakums->registracijas_beigu_datums) {
            return null;
        }

        $registracijasBeiguLaiks = $pasakums->registracijas_beigu_laiks ?: '23:59';

        return Carbon::parse($pasakums->registracijas_beigu_datums . ' ' . $registracijasBeiguLaiks);
    }

    private function varAtstatAtsauksmi($lietotajs, $pasakums): bool
    {
        if (!$lietotajs) {
            return false;
        }

        return PasakumuPieteikums::where('pasakums_id', $pasakums->ID)
            ->where('lietotajs_id', $lietotajs->ID)
            ->where('statuss', 'Apmeklets')
            ->exists();
    }
}