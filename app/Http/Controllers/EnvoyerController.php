<?php

namespace App\Http\Controllers;

use App\Models\Envoyer;
use App\Models\Tournois;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnvoyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $envoyers = Envoyer::with(['tournoi', 'inscrit'])->latest()->get();
        return view('envoyer.index', compact('envoyers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $tournoi = Tournois::findOrFail($id);
        return view('envoyer.create', compact('tournoi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $tournoiId)
{
    $request->validate([
        'capture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $tournoi = Tournois::findOrFail($tournoiId);

    if ($request->hasFile('capture')) {
        $path = $request->file('capture')->store('captures', 'public');

        // ✅ DÉTECTION AUTOMATIQUE du guard
        if (Auth::guard('participant')->check()) {
            $inscritId = Auth::guard('participant')->id();
        } elseif (Auth::check()) {
            // Si admin, utilisez un inscrit_id par défaut ou gérez différemment
            $inscritId = 1; // Ou une autre logique
        } else {
            return redirect('/participant/login')->with('error', 'Non connecté.');
        }

        Envoyer::create([
            'inscrit_id' => $inscritId,
            'tournoi_id' => $tournoi->id,
            'image' => $path,
        ]);

        return redirect()->route('participant')->with('success', 'Capture envoyée avec succès !');
    }

    return redirect()->back()->with('error', 'Erreur lors du téléchargement.');
}

    /**
     * Display the specified resource.
     */
    public function show(Envoyer $envoyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Envoyer $envoyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Envoyer $envoyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Envoyer $envoyer)
    {
        //
    }
}
