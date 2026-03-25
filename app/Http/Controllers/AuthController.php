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

        if (!$user || !Hash::check($credentials['password'], $user->parole)) {
            return back()->withErrors([
                'epasts' => 'Nepareizs e-pasts vai parole.',
            ])->withInput();
        }

        if ((int)$user->aktivs !== 1) {
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
        'uzvards' => 'required|string|max:25',
        'epasts' => 'required|email|max:50|unique:lietotaji,epasts',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $hashedPassword = Hash::make($validated['password']);

    Lietotajs::create([
        'vards' => $validated['vards'],
        'uzvards' => $validated['uzvards'],
        'epasts' => $validated['epasts'],
        'email' => $validated['epasts'],
        'loma' => 'Lietotajs',
        'parole' => $hashedPassword,
        'password' => $hashedPassword,
        'aktivs' => 0,
    ]);

    return redirect()->route('login')->with(
        'success',
        'Reģistrācija veiksmīga. Gaidiet profila apstiprināšanu.'
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