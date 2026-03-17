<?php

namespace App\Http\Controllers;

use App\Models\Envoyer;
use App\Models\Inscrit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Ajoutez cet import

class ParticipantController extends Controller
{
    public function index()
    {
        // Récupérer tous les participants (inscrits) avec leurs statistiques
        $participants = Inscrit::withCount(['envoyers as captures_count'])
            ->withCount(['envoyers as tournois_count' => function($query) {
                $query->select(DB::raw('count(distinct tournoi_id)')); // Utilisez DB::raw
            }])
            ->latest()
            ->get();

        return view('participant.index', compact('participants'));
    }

    public function dashboard()
    {
        // Récupérer l'utilisateur connecté
        $participant = Auth::guard('participant')->user();

        // Envoyer à la vue participant.blade.php
        return view('participant', compact('participant'));
    }

    public function show($id)
    {
        $participant = Inscrit::find($id);

        if (!$participant) {
            return redirect()->route('envoyer.index')->with('error', 'Participant non trouvé');
        }

        $capturesCount = Envoyer::where('inscrit_id', $id)->count();
        $tournoisCount = Envoyer::where('inscrit_id', $id)->distinct('tournoi_id')->count('tournoi_id');
        $dernieresCaptures = Envoyer::where('inscrit_id', $id)
            ->with('tournoi')
            ->latest()
            ->take(5)
            ->get();

        return view('participant.show', compact(
            'participant',
            'capturesCount',
            'tournoisCount',
            'dernieresCaptures'
        ));
    }

    public function logout(Request $request)
    {
        Auth::guard('participant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
