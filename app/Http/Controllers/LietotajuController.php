<?php

namespace App\Http\Controllers;

use App\Models\Lietotajs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LietotajuController extends Controller
{
    public function index()
    {
        $data = Lietotajs::orderBy('ID')->get();
        return view('lietotaji.index', compact('data'));
    }

    public function create()
    {
        return view('lietotaji.create');
    }

    public function store(Request $request)
    {
        $veidotajsIrAdmins = auth()->user()?->loma === 'Admin';

        $validated = $request->validate([
            'vards' => 'required|string|max:45',
            'uzvards' => 'required|string|max:25',
            'epasts' => 'required|email|max:50|unique:lietotaji,epasts',
            'password' => 'required|string|min:8|confirmed',
            'loma' => $veidotajsIrAdmins
                ? 'required|in:Admin,Darbinieks,Lietotajs'
                : 'nullable',
        ]);

        $hashedPassword = Hash::make($validated['password']);
        $jaunaLoma = $veidotajsIrAdmins ? $validated['loma'] : 'Lietotajs';

        Lietotajs::create([
            'vards' => $validated['vards'],
            'uzvards' => $validated['uzvards'],
            'epasts' => $validated['epasts'],
            'email' => $validated['epasts'],
            'loma' => $jaunaLoma,
            'parole' => $hashedPassword,
            'password' => $hashedPassword,
            'aktivs' => 1,
        ]);

        return redirect()->route('lietotaji.index')->with('success', 'Lietotājs veiksmīgi pievienots.');
    }

    public function edit($id)
    {
        $item = Lietotajs::findOrFail($id);
        return view('lietotaji.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Lietotajs::findOrFail($id);

        $validated = $request->validate([
            'vards' => 'required|string|max:45',
            'uzvards' => 'required|string|max:25',
            'epasts' => 'required|email|max:50|unique:lietotaji,epasts,' . $id . ',ID',
            'loma' => 'required|in:Admin,Darbinieks,Lietotajs',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $item->vards = $validated['vards'];
        $item->uzvards = $validated['uzvards'];
        $item->epasts = $validated['epasts'];
        $item->email = $validated['epasts'];
        $item->loma = $validated['loma'];

        if (!empty($validated['password'])) {
            $hashedPassword = Hash::make($validated['password']);
            $item->parole = $hashedPassword;
            $item->password = $hashedPassword;
        }

        $item->save();

        return redirect()->route('lietotaji.index')->with('success', 'Lietotājs veiksmīgi atjaunināts.');
    }

    public function destroy($id)
    {
        $item = Lietotajs::findOrFail($id);

        if ((int)auth()->id() === (int)$item->ID) {
            return redirect()->route('lietotaji.index')->withErrors(['Nevar dzēst pašam savu kontu.']);
        }

        $item->delete();

        return redirect()->route('lietotaji.index')->with('success', 'Lietotājs veiksmīgi dzēsts.');
    }
}