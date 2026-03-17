<?php

namespace App\Http\Controllers;

use App\Models\Participations;
use App\Models\Tournois;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipationsController extends Controller
{
    /**
     * Affiche la page de participation à un tournoi.
     */
    public function create($id)
    {
        $tournoi = Tournois::findOrFail($id);
        return view('participant.participer', compact('tournoi'));
    }

    /**
     * Enregistre une nouvelle participation.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'capture' => 'required|image|mimes:jpg,png,jpeg|max:4096',
        ]);

        $tournoi = Tournois::findOrFail($id);
        $imageName = time() . '.' . $request->capture->extension();
        $request->capture->move(public_path('captures'), $imageName);

        Participations::create([
            'user_id' => Auth::id(),
            'tournoi_id' => $tournoi->id,
            'image' => $imageName,
            'status' => 'en attente',
        ]);

        return redirect()->route('participant.dashboard')
            ->with('success', 'Votre participation a été envoyée avec succès !');
    }
    
}
