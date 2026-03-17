<?php

namespace App\Http\Controllers;

use App\Models\Commencer;
use App\Models\Tournois;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommencerController extends Controller
{
    /**
     * 🧩 ADMIN — Voir toutes les captures envoyées
     */
    public function index()
{
    $commencer = Commencer::with('inscrit', 'tournoi')->get();
    return view('commencer.index', compact('commencer'));
}


    /**
     * 🧩 ADMIN — Met à jour le statut d'une capture
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:en attente,approuvé,refusé',
        ]);

        $commencer = Commencer::findOrFail($id);
        $commencer->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Statut mis à jour avec succès !');
    }

    /**
     * 👤 PARTICIPANT — Affiche le formulaire pour envoyer la capture
     */
    public function create($id)
    {
        $tournoi = Tournois::findOrFail($id);
        return view('commencer.create', compact('tournoi'));
    }

    /**
     * 👤 PARTICIPANT — Stocke la capture envoyée
     */
    public function store(Request $request, $tournoiId)
{
    $request->validate([
        'capture' => 'required|image|max:2048',
    ]);

    $tournoi = Tournois::findOrFail($tournoiId);

    // Stockage de l'image
    $path = $request->file('capture')->store('captures', 'public');

    // Création de l'enregistrement
    Commencer::create([
        'inscrit_id' => auth()->id(),
        'tournoi_id' => $tournoi->id,
        'image' => $path,
        'status' => 'en attente', // par défaut
    ]);

    return redirect()->back()->with('success', 'Votre capture a été envoyée avec succès !');
}


}
