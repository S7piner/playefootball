<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantAuthController extends Controller
{
    public function showLoginForm() {
        return view('participant_login');
    }

    public function login(Request $request) {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    $credentials = $request->only('email', 'password');

    if (Auth::guard('participant')->attempt($credentials)) {
        // ✅ SOLUTION TEMPORAIRE - URL directe
        return redirect('/participant')->with('success', 'Bienvenue !');
    }

    return back()->withErrors([
        'email' => 'Identifiants incorrects.',
    ]);
}

    public function logout(Request $request) {
        Auth::guard('participant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
