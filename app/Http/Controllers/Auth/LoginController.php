<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        // Retourne la vue connexion.blade.php dans le dossier resources/views
        return view('Inscript.connexion'); // Assure-toi que le fichier est bien resources/views/connexion.blade.php
    }

    /**
     * Traiter la tentative de connexion
     */
    public function login(Request $request)
    {
        // Validation des champs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative d’authentification
        if (Auth::attempt($credentials)) {
            // Regénère la session pour plus de sécurité
            $request->session()->regenerate();

            // Redirection vers la page participant après connexion
            return redirect()->route('participant');
        }

        // En cas d’échec → retour avec message d’erreur
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Déconnecte l'utilisateur

        $request->session()->invalidate();       // Invalide la session
        $request->session()->regenerateToken();  // Regénère le token CSRF

        // Redirection vers la page d'accueil après logout
        return redirect('/');
    }
}
