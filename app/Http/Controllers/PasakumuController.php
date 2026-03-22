<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasakumi;
use App\Models\PasakumiImage;
use App\Models\Lietotajs;
use App\Models\Telpa;
use App\Models\Kategorija;
use Illuminate\Support\Facades\Storage;

class PasakumuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Pasakumi::with('images', 'darbinieks', 'telpa')->orderBy('ID', 'desc')->get();
        return view('alldata', ['data' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $darbinieki = Lietotajs::where('loma', '!=', 'Lietotajs')->get();
        $telpas = Telpa::all();
        $kategorijas = Kategorija::orderBy('nosaukums')->get();
        return view('create', ['darbinieki' => $darbinieki, 'telpas' => $telpas, 'kategorijas' => $kategorijas]);
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'sakuma_laiks' => 'required|date_format:H:i',
            'beigu_laiks' => 'required|date_format:H:i|after:sakuma_laiks',
            'apraksts' => 'nullable|max:255',
            'darbinieks_id' => 'required|exists:lietotaji,ID',
            'telpa_id' => 'required|exists:telpa,ID',
            'registracijas_beigu_datums' => 'nullable|date|after_or_equal:datums_no',
            'registracijas_beigu_laiks' => 'nullable|date_format:H:i',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Pasakumi::with('images', 'darbinieks', 'telpa')->findOrFail($id);
        return view('details', ['data' => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $item = Pasakumi::findOrFail($id);
        $darbinieki = Lietotajs::where('loma', '!=', 'Lietotajs')->get();
        $telpas = Telpa::all();
        return view('edit', ['item' => $item, 'darbinieki' => $darbinieki, 'telpas' => $telpas]);
    }

    /**
     * Update the specified resource in storage.
     */
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
            'registracijas_beigu_datums' => 'nullable|date|after_or_equal:datums_no',
            'registracijas_beigu_laiks' => 'nullable|date_format:H:i',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $pasakums = Pasakumi::findOrFail($id);

        // Delete associated images
        foreach ($pasakums->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $pasakums->delete();

        return redirect()->route('pasakumi.index')->with('success', 'Pasākums veiksmīgi dzēsts.');
    }

    /**
     * Delete a specific image from a pasakums.
     */
    public function deleteImage($pasakumiId, $imageId)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $image = PasakumiImage::where('id', $imageId)->where('pasakumi_id', $pasakumiId)->firstOrFail();
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()->back()->with('success', 'Attēls veiksmīgi dzēsts.');
    }
}