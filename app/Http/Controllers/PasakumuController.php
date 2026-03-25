<?php

namespace App\Http\Controllers;

use App\Models\Kategorija;
use App\Models\Lietotajs;
use App\Models\Pasakumi;
use App\Models\PasakumiAtsauksme;
use App\Models\PasakumiImage;
use App\Models\PasakumuAtsauksme;
use App\Models\PasakumuPieteikums;
use App\Models\Telpa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PasakumuController extends Controller
{
    public function index()
    {
        $items = Pasakumi::with(['images', 'darbinieks', 'telpa', 'aktiviePieteikumi'])->orderBy('ID', 'desc')->get();
        return view('alldata', ['data' => $items]);
    }

    public function create(Request $request)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $darbinieki = Lietotajs::whereIn('loma', ['Admin', 'Darbinieks'])
            ->orderBy('vards')
            ->get();

        $telpas = Telpa::orderBy('nosaukums')->get();
        $kategorijas = Kategorija::orderBy('nosaukums')->get();

        return view('create', compact('darbinieki', 'telpas', 'kategorijas'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $validated = $request->validate([
            'nosaukums' => 'required|max:45',
            'kategorija' => 'required|max:45',
            'datums_no' => 'required|date',
            'datums_lidz' => 'required|date|after_or_equal:datums_no',
            'laiks_no' => 'required|date_format:H:i',
            'laiks_lidz' => 'required|date_format:H:i|after:laiks_no',
            'apraksts' => 'nullable|max:255',
            'darbinieks_id' => 'required|exists:lietotaji,ID',
            'telpa_id' => 'required|exists:telpa,ID',
            'registracijas_beigu_datums' => 'nullable|date',
            'registracijas_beigu_laiks' => 'nullable|date_format:H:i',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->parbauditTelpasPieejamibu(
            $validated['telpa_id'],
            $validated['datums_no'],
            $validated['datums_lidz'],
            $validated['laiks_no'],
            $validated['laiks_lidz']
        );

        $this->parbauditDarbiniekaPieejamibu(
            $validated['darbinieks_id'],
            $validated['datums_no'],
            $validated['datums_lidz'],
            $validated['laiks_no'],
            $validated['laiks_lidz']
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

        return redirect()->route('pasakumi.index')->with('success', 'Pasākums veiksmīgi pievienots.');
    }

    public function show($id)
    {
        $item = Pasakumi::with([
            'images',
            'darbinieks',
            'telpa',
            'atsauksmes.lietotajs',
            'aktiviePieteikumi',
        ])->findOrFail($id);

        $lietotajaPieteikums = null;
        $varPieteikties = false;
        $varAtstatAtsauksmi = false;

        if (auth()->check()) {
            $lietotajaPieteikums = PasakumuPieteikums::where('pasakums_id', $item->ID)
                ->where('lietotajs_id', auth()->id())
                ->first();

            $varPieteikties = $this->varPieteikties(auth()->user(), $item, $lietotajaPieteikums);
            $varAtstatAtsauksmi = $this->varAtstatAtsauksmi(auth()->user(), $item);
        }

        return view('details', [
            'data' => $item,
            'lietotajaPieteikums' => $lietotajaPieteikums,
            'varPieteikties' => $varPieteikties,
            'varAtstatAtsauksmi' => $varAtstatAtsauksmi,
        ]);
    }

    public function edit($id)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $item = Pasakumi::findOrFail($id);
        $darbinieki = Lietotajs::whereIn('loma', ['Admin', 'Darbinieks'])->orderBy('vards')->get();
        $telpas = Telpa::orderBy('nosaukums')->get();

        return view('edit', compact('item', 'darbinieki', 'telpas'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $validated = $request->validate([
            'nosaukums' => 'required|max:45',
            'kategorija' => 'required|max:45',
            'datums_no' => 'required|date',
            'datums_lidz' => 'required|date|after_or_equal:datums_no',
            'laiks_no' => 'required|date_format:H:i',
            'laiks_lidz' => 'required|date_format:H:i|after:laiks_no',
            'apraksts' => 'nullable|max:255',
            'darbinieks_id' => 'required|exists:lietotaji,ID',
            'telpa_id' => 'required|exists:telpa,ID',
            'registracijas_beigu_datums' => 'nullable|date',
            'registracijas_beigu_laiks' => 'nullable|date_format:H:i',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->parbauditTelpasPieejamibu(
            $validated['telpa_id'],
            $validated['datums_no'],
            $validated['datums_lidz'],
            $validated['laiks_no'],
            $validated['laiks_lidz'],
            $id
        );

        $this->parbauditDarbiniekaPieejamibu(
            $validated['darbinieks_id'],
            $validated['datums_no'],
            $validated['datums_lidz'],
            $validated['laiks_no'],
            $validated['laiks_lidz'],
            $id
        );

        $pasakums = Pasakumi::findOrFail($id);
        $pasakums->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('pasakumi', 'public');

                PasakumiImage::create([
                    'pasakumi_id' => $pasakums->ID,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('pasakumi.index')->with('success', 'Pasākums veiksmīgi atjaunināts.');
    }

    public function destroy($id)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $pasakums = Pasakumi::findOrFail($id);

        foreach ($pasakums->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $pasakums->delete();

        return redirect()->route('pasakumi.index')->with('success', 'Pasākums veiksmīgi dzēsts.');
    }

    public function deleteImage($pasakumiId, $imageId)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $image = PasakumiImage::where('id', $imageId)
            ->where('pasakumi_id', $pasakumiId)
            ->firstOrFail();

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()->back()->with('success', 'Attēls veiksmīgi dzēsts.');
    }

    public function pieteikties($id)
    {
        $lietotajs = auth()->user();
        $pasakums = Pasakumi::with('telpa', 'aktiviePieteikumi')->findOrFail($id);

        if (!$lietotajs->irApstiprinats()) {
            return back()->withErrors(['pieteiksanas' => 'Tikai apstiprināti lietotāji var pieteikties pasākumam.']);
        }

        $eksiste = PasakumuPieteikums::where('pasakums_id', $pasakums->ID)
            ->where('lietotajs_id', $lietotajs->ID)
            ->first();

        if (!$this->varPieteikties($lietotajs, $pasakums, $eksiste)) {
            return back()->withErrors(['pieteiksanas' => 'Šim pasākumam pašlaik nevar pieteikties.']);
        }

        PasakumuPieteikums::create([
            'pasakums_id' => $pasakums->ID,
            'lietotajs_id' => $lietotajs->ID,
            'statuss' => 'Pieteikts',
        ]);

        return back()->with('success', 'Pieteikums veiksmīgi iesniegts.');
    }

    public function atzimetApmekletu($pasakumsId, $lietotajsId)
    {
        if (!in_array(auth()->user()->loma, ['Admin', 'Darbinieks'])) {
            abort(403);
        }

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
        $pasakums = Pasakumi::findOrFail($id);
        $lietotajs = auth()->user();

        if (!$this->varAtstatAtsauksmi($lietotajs, $pasakums)) {
            return back()->withErrors(['atsauksme' => 'Atsauksmi var atstāt tikai lietotājs, kas apmeklēja pasākumu.']);
        }

        $validated = $request->validate([
            'vertejums' => 'required|integer|min:1|max:5',
            'atsauksme' => 'nullable|string|max:1000',
        ]);

        PasakumuAtsauksme::updateOrCreate(
            [
                'pasakums_id' => $pasakums->ID,
                'lietotajs_id' => $lietotajs->ID,
            ],
            $validated + ['izveidots_at' => now()]
        );

        return back()->with('success', 'Atsauksme saglabāta.');
    }

    private function parbauditTelpasPieejamibu($telpaId, $datumsNo, $datumsLidz, $laiksNo, $laiksLidz, $ignoreId = null): void
    {
        $query = Pasakumi::where('telpa_id', $telpaId)
            ->where('datums_no', '<=', $datumsLidz)
            ->where('datums_lidz', '>=', $datumsNo)
            ->where('laiks_no', '<', $laiksLidz)
            ->where('laiks_lidz', '>', $laiksNo);

        if ($ignoreId) {
            $query->where('ID', '!=', $ignoreId);
        }

        if ($query->exists()) {
            abort(422, 'Izvēlētā telpa šajā laikā nav brīva.');
        }
    }

    private function parbauditDarbiniekaPieejamibu($darbinieksId, $datumsNo, $datumsLidz, $laiksNo, $laiksLidz, $ignoreId = null): void
    {
        $query = Pasakumi::where('darbinieks_id', $darbinieksId)
            ->where('datums_no', '<=', $datumsLidz)
            ->where('datums_lidz', '>=', $datumsNo)
            ->where('laiks_no', '<', $laiksLidz)
            ->where('laiks_lidz', '>', $laiksNo);

        if ($ignoreId) {
            $query->where('ID', '!=', $ignoreId);
        }

        if ($query->exists()) {
            abort(422, 'Izvēlētais darbinieks šajā laikā jau ir piesaistīts citam pasākumam.');
        }
    }

    private function varPieteikties($lietotajs, $pasakums, $esošaisPieteikums = null): bool
    {
        if (!$lietotajs || !$lietotajs->irApstiprinats()) {
            return false;
        }

        if ($esošaisPieteikums) {
            return false;
        }

        if ($pasakums->registracijas_beigu_datums && $pasakums->registracijas_beigu_laiks) {
            $registracijasBeigas = \Carbon\Carbon::parse(
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