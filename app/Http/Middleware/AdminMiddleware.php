<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Si l'utilisateur est connecté ET est admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Sinon redirection
        return redirect('/')->with('error', 'Accès réservé aux administrateurs.');
    }
}
