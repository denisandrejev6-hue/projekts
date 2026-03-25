<?php

namespace App\Http\Controllers;

use App\Models\Lietotajs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'epasts' => 'required|email',
            'password' => 'required',
        ]);

        $user = Lietotajs::where('epasts', $credentials['epasts'])->first();

        if (!$user) {
            return back()->withErrors(['epasts' => 'Nepareizs e-pasts vai parole.'])->withInput();
        }

        if (!Hash::check($credentials['password'], $user->parole)) {
            return back()->withErrors(['epasts' => 'Nepareizs e-pasts vai parole.'])->withInput();
        }

        if ($user->registracijas_statuss !== 'Apstiprinats') {
            return back()->withErrors([
                'epasts' => 'Jūsu profils vēl nav apstiprināts.',
            ])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'vards' => 'required|string|max:45',
            'uzvards' => 'required|string|max:45',
            'epasts' => 'required|string|email|max:255|unique:lietotaji,epasts',
            'password' => 'required|string|confirmed|min:8',
        ]);

        Lietotajs::create([
            'vards' => $validated['vards'],
            'uzvards' => $validated['uzvards'],
            'epasts' => $validated['epasts'],
            'parole' => Hash::make($validated['password']),
            'loma' => 'Lietotajs',
            'registracijas_statuss' => 'Neapstiprinats',
        ]);

        return redirect()->route('login')->with(
            'success',
            'Reģistrācija veiksmīga. Jūsu profils gaida apstiprinājumu.'
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}