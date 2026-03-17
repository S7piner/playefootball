<?php

namespace App\Http\Controllers;

use App\Models\Inscrit;
use App\Models\Tournois; // Importez le modèle Tournois
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscritController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inscrit = Inscrit::all();
        return view('Inscrit.index', compact('inscrit'));
    }

    public function create()
    {
        return view('Inscript.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1️⃣ Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'pseudo' => 'required|string|max:255|unique:inscrits,pseudo',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|unique:inscrits,email',
            'pays' => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2️⃣ Création de l'inscrit
        $inscrit = Inscrit::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'pseudo' => $request->pseudo,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'pays' => $request->pays,
            'password' => bcrypt($request->password),
        ]);

        // 3️⃣ Connexion automatique après inscription
        Auth::guard('participant')->login($inscrit);

        // 4️⃣ Redirection vers le dashboard du participant
        return redirect()->route('participant')->with('success', 'Bienvenue ' . $inscrit->pseudo . ' !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inscrit $inscrit)
    {
        return view('Inscript.show', compact('inscrit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inscrit $inscrit)
    {
        return view('Inscript.edit', compact('inscrit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inscrit $inscrit)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'pseudo' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:inscrits,email,' . $inscrit->id,
            'pays' => 'required|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $inscrit->nom = $request->nom;
        $inscrit->prenom = $request->prenom;
        $inscrit->pseudo = $request->pseudo;
        $inscrit->telephone = $request->telephone;
        $inscrit->email = $request->email;
        $inscrit->pays = $request->pays;
        if ($request->filled('password')) {
            $inscrit->password = bcrypt($request->password);
        }
        $inscrit->save();

        return redirect()->route('participant')->with('success', 'Inscription mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inscrit $inscrit)
    {
        $inscrit->delete();
        return redirect()->route('participant')->with('success', 'Inscription supprimée avec succès !');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048', // max 2MB
        ]);

        $user = auth()->guard('participant')->user(); // récupère l'inscrit connecté

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);
            $user->avatar = 'uploads/avatars/' . $filename;
            $user->save();
        }

        return redirect()->back();
    }

    public function participer($id)
    {
        $inscrit = Inscrit::findOrFail($id);

        // On autorise le participant
        $inscrit->update([
            'authorized' => true,
        ]);

        return redirect()->route('inscrit.attente')->with('success', 'Participant autorisé !');
    }









    /**
     * Autoriser directement un participant depuis les captures
     */
    public function authorizeDirect(Request $request)
{
    $inscritId = $request->input('inscrit_id');
    $tournoiId = $request->input('tournoi_id');

    // DEBUG FORCÉ
    \Log::info("=== ULTIMATE DEBUG ===");
    \Log::info("Inscrit ID: " . $inscritId);
    \Log::info("Tournoi ID: " . $tournoiId);
    \Log::info("Toutes les données: " . json_encode($request->all()));

    $inscrit = Inscrit::find($inscritId);

    if (!$inscrit) {
        \Log::error("Participant non trouvé: " . $inscritId);
        return redirect()->back()->with('error', 'Participant non trouvé');
    }

    \Log::info("Avant - authorized: " . $inscrit->authorized . ", tournoi_id: " . $inscrit->tournoi_id);

    // METHODE ULTRA-SIMPLE
    $inscrit->authorized = true;
    $inscrit->tournoi_id = $tournoiId;
    $result = $inscrit->save();

    \Log::info("Save result: " . ($result ? 'SUCCESS' : 'FAILED'));
    \Log::info("Après - authorized: " . $inscrit->authorized . ", tournoi_id: " . $inscrit->tournoi_id);

    return redirect()->route('inscrit.attente', ['tournoi_id' => $tournoiId])
                     ->with('success', 'Participant ' . $inscrit->pseudo . ' autorisé !');
}

public function attente(Request $request)
{
    $tournoiId = $request->input('tournoi_id');

    if (!$tournoiId) {
        return redirect()->back()->with('error', 'Tournoi non spécifié');
    }

    // SEULEMENT les participants avec CE tournoi_id
    $inscrits = Inscrit::where('authorized', true)
                        ->where('tournoi_id', $tournoiId)
                        ->get();

    $tournoi = Tournois::find($tournoiId);
    $tournois = Tournois::latest()->get();

    return view('inscrit.attente', compact('inscrits', 'tournois', 'tournoi'));
}

    /**
     * Ancienne méthode pour participants autorisés (gardée pour compatibilité)
     */
    public function participantsAutorises(Request $request)
    {
        $tournoiId = $request->input('tournoi_id');

        // Récupère uniquement les participants de CE tournoi
        $inscrits = Inscrit::where('authorized', true)
                            ->where('tournoi_id', $tournoiId)
                            ->get();

        $tournoi = Tournois::find($tournoiId);
        $tournois = Tournois::latest()->get();

        return view('inscrit.attente', compact('inscrits', 'tournois', 'tournoi'));
    }

    /**
     * Autoriser un participant (méthode alternative)
     */
    public function authorizeParticipant($id)
    {
        $inscrit = Inscrit::findOrFail($id);

        $inscrit->update([
            'authorized' => true,
        ]);

        return redirect()->back()->with('success', 'Participant autorisé avec succès !');
    }

    public function updateClassement(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|exists:inscrits,id',
            'mj' => 'required|integer|min:0',
            'victoires' => 'required|integer|min:0',
            'nuls' => 'required|integer|min:0',
            'defaites' => 'required|integer|min:0',
            'buts_contre' => 'required|integer|min:0',
            'points' => 'required|integer|min:0',
        ]);

        // Ici vous pouvez stocker les statistiques dans votre base de données
        // Par exemple, créez une table 'classements' ou ajoutez des colonnes à 'inscrits'

        return redirect()->back()->with('success', 'Statistiques mises à jour avec succès!');
    }

    public function envoyerClassement(Request $request)
    {
        // Logique pour envoyer les classements (email, notification, etc.)

        return redirect()->back()->with('success', 'Classements envoyés aux participants!');
    }
}
