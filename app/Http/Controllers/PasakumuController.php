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
        $aiznemtieLaiki = $this->aiznemtieTelpuLaiki();

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
            'registracijas_beigu_datums' => 'nullable|date',
            'registracijas_beigu_laiks' => 'nullable|date_format:H:i',
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
            'aktiviePieteikumi'
        ])->findOrFail($id);

        $lietotajaPieteikums = null;
        $varPieteikties = false;
        $varAtstatAtsauksmi = false;

        if (auth()->check()) {
            $lietotajaPieteikums = PasakumuPieteikums::where('pasakums_id', $data->ID)
                ->where('lietotajs_id', auth()->id())
                ->first();

            $varPieteikties = $this->varPieteikties(auth()->user(), $data, $lietotajaPieteikums);
            $varAtstatAtsauksmi = $this->varAtstatAtsauksmi(auth()->user(), $data);
        }

        return view('details', compact(
            'data',
            'lietotajaPieteikums',
            'varPieteikties',
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
        $aiznemtieLaiki = $this->aiznemtieTelpuLaiki($id);

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
            'registracijas_beigu_datums' => 'nullable|date',
            'registracijas_beigu_laiks' => 'nullable|date_format:H:i',
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

        if (!$lietotajs || !$lietotajs->irApstiprinats()) {
            return back()->withErrors([
                'pieteiksanas' => 'Tikai apstiprināts lietotājs var pieteikties pasākumam.',
            ]);
        }

        $esošais = PasakumuPieteikums::where('pasakums_id', $id)
            ->where('lietotajs_id', $lietotajs->ID)
            ->first();

        if (!$this->varPieteikties($lietotajs, $pasakums, $esošais)) {
            return back()->withErrors([
                'pieteiksanas' => 'Šim pasākumam pašlaik nevar pieteikties.',
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
        $query = Pasakumi::where('darbinieks_id', $darbinieksId)
            ->where('datums_no', '<=', $datumsLidz)
            ->where('datums_lidz', '>=', $datumsNo)
            ->where('sakuma_laiks', '<', $beiguLaiks)
            ->where('beigu_laiks', '>', $sakumaLaiks);

        if ($ignoreId) {
            $query->where('ID', '!=', $ignoreId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'darbinieks_id' => 'Izvēlētais darbinieks šajā laikā jau ir aizņemts.',
            ]);
        }
    }

    private function pieejamasTelpas($datumsNo, $datumsLidz, $sakumaLaiks, $beiguLaiks, $ignoreId = null)
    {
        $aiznemtasTelpas = Pasakumi::query()
            ->when($ignoreId, fn ($query) => $query->where('ID', '!=', $ignoreId))
            ->where('datums_no', '<=', $datumsLidz)
            ->where('datums_lidz', '>=', $datumsNo)
            ->where('sakuma_laiks', '<', $beiguLaiks)
            ->where('beigu_laiks', '>', $sakumaLaiks)
            ->pluck('telpa_id');

        return Telpa::query()
            ->whereNotIn('ID', $aiznemtasTelpas)
            ->orderBy('nosaukums')
            ->get(['ID', 'nosaukums', 'ietilpiba']);
    }

    private function aiznemtieTelpuLaiki($ignoreId = null)
    {
        return Pasakumi::query()
            ->when($ignoreId, fn ($query) => $query->where('ID', '!=', $ignoreId))
            ->get(['telpa_id', 'datums_no', 'datums_lidz', 'sakuma_laiks', 'beigu_laiks']);
    }

    private function varPieteikties($lietotajs, $pasakums, $esosaisPieteikums = null): bool
    {
        if (!$lietotajs || !$lietotajs->irApstiprinats()) {
            return false;
        }

        if ($esosaisPieteikums) {
            return false;
        }

        if ($pasakums->registracijas_beigu_datums && $pasakums->registracijas_beigu_laiks) {
            $registracijasBeigas = Carbon::parse(
                $pasakums->registracijas_beigu_datums . ' ' . $pasakums->registracijas_beigu_laiks
            );

            if (now()->gt($registracijasBeigas)) {
                return false;
            }
        }

        $ietilpiba = (int) ($pasakums->telpa->ietilpiba ?? 0);
        $aiznemtasVietas = $pasakums->aktiviePieteikumi()->count();

        if ($ietilpiba > 0 && $aiznemtasVietas >= $ietilpiba) {
            return false;
        }

        return true;
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