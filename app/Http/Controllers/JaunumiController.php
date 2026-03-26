<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jaunumi;
use App\Models\JaunumiImage;
use Illuminate\Support\Facades\Storage;

class JaunumiController extends Controller
{
    /**
     * Parāda visu jaunumu sarakstu
     */
    public function index()
    {
        $items = Jaunumi::with('images')->orderBy('publicets_datums', 'desc')->get();
        return view('jaunumi.index', ['data' => $items]);
    }

    /**
     * Parāda formu jaunas ziņas izveidei
     */
    public function create()
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }
        return view('jaunumi.create');
    }

    /**
     * Saglabā jaunu ziņu datubāzē
     */
    public function store(Request $request)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $validated = $request->validate([
            'virsraksts' => 'required|max:255',
            'apraksts' => 'required',
            'publicets_datums' => 'required|date',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $jaunumi = Jaunumi::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('jaunumi', 'public');
                JaunumiImage::create([
                    'jaunumi_id' => $jaunumi->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('jaunumi.index')->with('success', 'Ziņa veiksmīgi pievienota.');
    }

    /**
     * Parāda formu ziņas rediģēšanai
     */
    public function edit($id)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $item = Jaunumi::findOrFail($id);
        return view('jaunumi.edit', ['item' => $item]);
    }

    /**
     * Atjaunina ziņas datus datubāzē
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $item = Jaunumi::findOrFail($id);

        $validated = $request->validate([
            'virsraksts' => 'required|max:255',
            'apraksts' => 'required',
            'publicets_datums' => 'required|date',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $item->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('jaunumi', 'public');
                JaunumiImage::create([
                    'jaunumi_id' => $item->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('jaunumi.index')->with('success', 'Ziņa veiksmīgi atjaunināta.');
    }

    /**
     * Parāda konkrēta jaunuma detaļas.
     */
    public function show($id)
    {
        $item = Jaunumi::with('images')->findOrFail($id);
        return view('jaunumi.show', ['item' => $item]);
    }

    /**
     * Izdzēš ziņu no datubāzes.
     */
    public function destroy($id)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $item = Jaunumi::findOrFail($id);

        // Pirms ziņas dzēšanas noņem arī saistītos attēlu failus un ierakstus.
        foreach ($item->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $item->delete();

        return redirect()->route('jaunumi.index')->with('success', 'Ziņa veiksmīgi dzēsta.');
    }

    /**
        * Izdzēš konkrētu attēlu no jaunuma.
     */
    public function deleteImage($jaunumiId, $imageId)
    {
        if (auth()->user()->loma === 'Lietotajs') {
            abort(403);
        }

        $image = JaunumiImage::where('id', $imageId)->where('jaunumi_id', $jaunumiId)->firstOrFail();
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()->back()->with('success', 'Attēls veiksmīgi dzēsts.');
    }}
