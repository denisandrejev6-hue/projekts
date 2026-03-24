<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::attempt(['epasts' => $credentials['epasts'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'epasts' => __('auth.failed'),
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'epasts' => 'required|string|email|max:255|unique:lietotaji',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = \App\Models\Lietotaji::create($validated);

        Auth::login($user);

        return redirect()->intended('/');
    }

    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    }