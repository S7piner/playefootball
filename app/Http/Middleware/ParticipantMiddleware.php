<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ici on vérifie le guard participant
        if (Auth::guard('participant')->check()) {
            return $next($request);
        }

        return redirect('/participant/login')->with('error', 'Veuillez vous connecter.');
    }
}
