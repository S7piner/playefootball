<?php

namespace App\Http\Controllers;

use App\Models\Classement;
use App\Models\Inscrit;
use App\Models\Journer;
use App\Models\Tournois;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TournoisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournois = Tournois::latest()->get();
        return view('tournois.index', compact('tournois'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inscrits = Inscrit::where('authorized', true)->get();
        $tournois = Tournois::latest()->get();
        return view('tournois.create', compact('inscrits', 'tournois'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'caution' => 'required|integer|min:0',
            'date' => 'required|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tournois', 'public');
        }

        Tournois::create([
            'nom' => $request->nom,
            'image' => $imagePath,
            'description' => $request->description,
            'caution' => $request->caution,
            'date' => $request->date,
        ]);

        return redirect()->route('tournois.index')->with('success', 'Tournoi ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournois $tournois)
    {
        return view('tournois.show', compact('tournois'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournois $tournois)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournois $tournois)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournois $tournois)
    {
        // Supprime l'image du stockage si elle existe
        if ($tournois->image && Storage::disk('public')->exists($tournois->image)) {
            Storage::disk('public')->delete($tournois->image);
        }

        // Supprime le tournoi de la base de données
        $tournois->delete();

        // Redirige avec un message de succès
        return redirect()->route('tournois.index')->with('success', 'Tournoi supprimé avec succès !');
    }

    /**
     * Display a listing of the resource for participants.
     */
    public function publicIndex()
    {
        $tournois = Tournois::orderBy('created_at', 'desc')->get();
        return view('participant.tournois', compact('tournois'));
    }

    /**
     * Display the specified resource for participants.
     */
    public function publicShow(Tournois $tournois)
    {
        return view('participant.tournois_show', compact('tournois'));
    }

    /**
     * Génère les journées pour un tournoi spécifique
     */
    public function genererJournees(Request $request)
{
    $request->validate([
        'tournoi_id' => 'required|exists:tournois,id',
        'date_debut' => 'required|date'
    ]);

    // Vérifier que le tournoi existe
    $tournoi = Tournois::findOrFail($request->tournoi_id);

    // CORRECTION : Récupérer seulement les participants de CE tournoi
    $participants = Inscrit::where('authorized', true)
                          ->where('tournoi_id', $tournoi->id) // ← AJOUTER CETTE LIGNE
                          ->pluck('id')
                          ->toArray();

    if (count($participants) < 2) {
        return redirect()->back()->with('error', 'Au moins 2 participants autorisés sont nécessaires.');
    }

    // Supprimer les anciennes journées pour ce tournoi
    Journer::where('tournoi_id', $tournoi->id)->delete();

    // Supprimer les anciens classements pour ce tournoi
    Classement::where('tournoi_id', $tournoi->id)->delete();

    // Générer le calendrier
    $calendrier = $this->genererCalendrierRoundRobin($participants, $tournoi->id, $request->date_debut);

    // Initialiser les classements pour ce tournoi
    $this->initialiserClassements($participants, $tournoi->id);

    return redirect()->route('admin.calendrier', $tournoi->id)
                    ->with('success', 'Calendrier généré avec ' . count($calendrier) . ' journées pour ' . $tournoi->nom . '!');
}

    public function genererCalendrierRoundRobin($participantsList, $tournoiId, $dateDebut)
{
    $nombreParticipants = count($participantsList);

    // CORRECTION MANUELLE - 8 participants = 7 journées
    if ($nombreParticipants === 8) {
        $nombreJournees = 7;
        $matchsParJournee = 4;
        \Log::info("🔧 Correction manuelle: 8 participants = 7 journées, 4 matchs/jour");
    } else {
        // Logique normale
        if ($nombreParticipants % 2 !== 0) {
            $participantsList[] = null;
            $nombreParticipants = count($participantsList);
        }
        $nombreJournees = $nombreParticipants - 1;
        $matchsParJournee = (int)($nombreParticipants / 2);
    }

    \Log::info("🎯 CONFIG FINALE: $nombreParticipants participants, $nombreJournees journées, $matchsParJournee matchs/jour");

    $calendrier = [];

    // Algorithm round-robin standard
    for ($journee = 1; $journee <= $nombreJournees; $journee++) {
        $matches = [];

        for ($i = 0; $i < $matchsParJournee; $i++) {
            $joueurA = $participantsList[$i];
            $joueurB = $participantsList[$nombreParticipants - 1 - $i];

            if ($joueurA && $joueurB) {
                $match = Journer::create([
                    'numero_journee' => $journee,
                    'tournoi_id' => $tournoiId,
                    'joueur1_id' => $joueurA,
                    'joueur2_id' => $joueurB,
                    'date_match' => \Carbon\Carbon::parse($dateDebut)->addDays($journee - 1),
                    'statut' => 'programme',
                ]);
                $matches[] = $match;
            }
        }

        $calendrier[] = $matches;

        // Rotation
        $premier = array_shift($participantsList);
        $second = array_shift($participantsList);
        $dernier = array_pop($participantsList);

        array_unshift($participantsList, $premier);
        array_unshift($participantsList, $dernier);
        array_push($participantsList, $second);
    }

    \Log::info("✅ CALENDRIER GÉNÉRÉ: " . count($calendrier) . " journées");
    return $calendrier;
}

    private function initialiserClassements($participantsIds, $tournoiId)
{
    // SUPPRIMER les anciens classements pour CE tournoi
    \App\Models\Classement::where('tournoi_id', $tournoiId)->delete();

    // CRÉER les classements seulement pour les participants de CE tournoi
    foreach ($participantsIds as $participantId) {
        // Vérifier que le participant existe et appartient à ce tournoi
        $inscrit = \App\Models\Inscrit::where('id', $participantId)
                                     ->where('tournoi_id', $tournoiId)
                                     ->where('authorized', true)
                                     ->first();

        if ($inscrit) {
            \App\Models\Classement::create([
                'tournoi_id' => $tournoiId,
                'inscrit_id' => $participantId,
                'mj' => 0,
                'g' => 0,
                'n' => 0,
                'p' => 0,
                'bc' => 0,
                'points' => 0,
            ]);
        }
    }
}

    /**
     * Liste tous les tournois avec leurs calendriers
     */
    public function listeTournoisAvecCalendriers()
    {
        $tournois = Tournois::latest()->get();
        return view('admin.liste-avec-calendriers', compact('tournois'));
    }

    /**
     * Affiche le calendrier d'un tournoi spécifique
     */
    public function calendrierParTournoi($tournoiId)
    {
        // Récupère le tournoi spécifique
        $tournoi = Tournois::findOrFail($tournoiId);

        // Récupère les journées pour ce tournoi
        $journees = Journer::with(['joueur1', 'joueur2'])
            ->where('tournoi_id', $tournoiId)
            ->orderBy('numero_journee')
            ->get()
            ->groupBy('numero_journee');

        // Récupère aussi tous les tournois pour la navigation
        $tournois = Tournois::latest()->get();

        return view('admin.calendrier', compact('journees', 'tournoi', 'tournois'));
    }

    public function calendrier(Request $request)
{
    $tournoiId = $request->get('tournoi', Tournois::first()?->id);
    $tournoi = Tournois::find($tournoiId);

    $journees = Journer::with(['joueur1', 'joueur2'])
        ->where('tournoi_id', $tournoiId)
        ->orderBy('numero_journee')
        ->get()
        ->groupBy('numero_journee');

    $tournois = Tournois::all();

    return view('admin.calendrier', compact('journees', 'tournois', 'tournoiId', 'tournoi'));
}

    /**
     * Liste tous les tournois avec leurs classements
     */
    public function listeTournoisAvecClassements()
    {
        $tournois = Tournois::latest()->get();
        return view('admin.liste-avec-classements', compact('tournois'));
    }

    /**
     * Affiche le classement d'un tournoi spécifique
     */
    /**
 * Affiche le classement d'un tournoi spécifique
 */
public function classementParTournoi($tournoiId)
{
    // Récupère le tournoi spécifique
    $tournoi = Tournois::findOrFail($tournoiId);

    // CORRECTION : Tri correct du classement
    $classements = Classement::with('inscrit')
        ->where('tournoi_id', $tournoiId)
        ->orderBy('points', 'DESC')
        ->orderBy('dif', 'DESC')  // ← Tri par différence de buts en SECOND
        ->orderBy('bp', 'DESC')   // ← Tri par buts pour en TROISIÈME
        ->orderBy('bc', 'ASC')    // ← Tri par buts contre en QUATRIÈME
        ->get();

    // Récupère aussi tous les tournois pour la navigation
    $tournois = Tournois::latest()->get();

    return view('admin.classement', compact('classements', 'tournoi', 'tournois'));
}

    public function sauvegarderScore(Request $request)
    {
        \Log::info('🎯 DEBUT sauvegarderScore');
        \Log::info('Données reçues:', $request->all());

        try {
            $request->validate([
                'match_id' => 'required|exists:journers,id',
                'score_joueur1' => 'required|integer|min:0',
                'score_joueur2' => 'required|integer|min:0',
            ]);

            $match = Journer::find($request->match_id);

            if (!$match) {
                \Log::error('Match non trouvé ID: ' . $request->match_id);
                return response()->json(['success' => false, 'message' => 'Match non trouvé'], 404);
            }

            \Log::info('Match trouvé:', ['id' => $match->id, 'statut_avant' => $match->statut]);

            // SAUVEGARDER LE SCORE
            $match->update([
                'score_joueur1' => $request->score_joueur1,
                'score_joueur2' => $request->score_joueur2,
                'statut' => 'termine'
            ]);

            \Log::info('Score sauvegardé:', [
                'match_id' => $match->id,
                'score' => $request->score_joueur1 . '-' . $request->score_joueur2,
                'statut_apres' => $match->statut
            ]);

            // METTRE À JOUR LE CLASSEMENT
            $this->mettreAJourClassement($match);

            \Log::info('✅ SAUVEGARDE RÉUSSIE pour match ID: ' . $match->id);

            return response()->json([
                'success' => true,
                'message' => 'Score sauvegardé avec succès!'
            ]);

        } catch (\Exception $e) {
            \Log::error('❌ ERREUR sauvegarderScore: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    private function mettreAJourClassement($match)
    {
        $tournoiId = $match->tournoi_id;

        // Mettre à jour le classement du joueur 1
        $this->mettreAJourJoueurClassement($tournoiId, $match->joueur1_id, $match->score_joueur1, $match->score_joueur2);

        // Mettre à jour le classement du joueur 2
        $this->mettreAJourJoueurClassement($tournoiId, $match->joueur2_id, $match->score_joueur2, $match->score_joueur1);
    }

    private function mettreAJourJoueurClassement($tournoiId, $joueurId, $butsPour, $butsContre)
{
    $classement = Classement::where('tournoi_id', $tournoiId)
        ->where('inscrit_id', $joueurId)
        ->first();

    if ($classement) {
        $classement->mj += 1;
        $classement->bp += $butsPour;    // ← AJOUTER
        $classement->bc += $butsContre;
        $classement->dif = $classement->bp - $classement->bc; // ← AJOUTER (calcul Dif)

        if ($butsPour > $butsContre) {
            $classement->g += 1;
            $classement->points += 3;
        } elseif ($butsPour == $butsContre) {
            $classement->n += 1;
            $classement->points += 1;
        } else {
            $classement->p += 1;
        }

        $classement->save();
    }
}

    /**
     * Ancienne méthode de classement (à garder pour compatibilité)
     */
    /**
 * Ancienne méthode de classement (à garder pour compatibilité)
 */
public function classement(Request $request)
{
    $tournoiId = $request->input('tournoi');

    // CORRECTION : Tri correct du classement
    $classements = \App\Models\Classement::where('tournoi_id', $tournoiId)
        ->with('inscrit')
        ->orderBy('points', 'DESC')
        ->orderBy('dif', 'DESC')  // ← Ajouter cette ligne
        ->orderBy('bp', 'DESC')   // ← Ajouter cette ligne
        ->orderBy('bc', 'ASC')    // ← Ajouter cette ligne
        ->get();

    $tournoi = \App\Models\Tournois::find($tournoiId);
    $tournois = \App\Models\Tournois::latest()->get();

    return view('admin.classement', compact('classements', 'tournois', 'tournoi'));
}

    /**
 * Affiche les journées, classement ET phase finale pour le participant
 */
public function participantJournees($id)
{
    $tournoi = Tournois::findOrFail($id);

    // Charger toutes les journées avec les infos des joueurs
    $journees = Journer::with(['joueur1', 'joueur2'])
        ->where('tournoi_id', $id)
        ->orderBy('numero_journee')
        ->get()
        ->groupBy('numero_journee');

    // CORRECTION : Charger le classement avec le bon ordre de tri
    $classements = Classement::with('inscrit')
        ->where('tournoi_id', $id)
        ->orderBy('points', 'DESC')
        ->orderBy('dif', 'DESC')  // ← Ajout du tri par différence de buts
        ->orderBy('bp', 'DESC')   // ← Ajout du tri par buts pour
        ->orderBy('bc', 'ASC')    // ← Tri par buts contre
        ->get();

    // AJOUTER LA PHASE FINALE
    $phaseFinale = [
        'quarts' => \App\Models\PhaseFinaleMatch::where('tournoi_id', $id)
            ->where('round', 'quarter')
            ->with(['player1', 'player2'])
            ->orderBy('order')
            ->get(),
        'demis' => \App\Models\PhaseFinaleMatch::where('tournoi_id', $id)
            ->where('round', 'semi')
            ->with(['player1', 'player2'])
            ->orderBy('order')
            ->get(),
        'finale' => \App\Models\PhaseFinaleMatch::where('tournoi_id', $id)
            ->where('round', 'final')
            ->with(['player1', 'player2'])
            ->get(),
    ];

    return view('participant.journees', compact('tournoi', 'journees', 'classements', 'phaseFinale'));
}

    /**
     * Réinitialise un tournoi spécifique
     */
    public function resetTournoi($tournoiId)
    {
        // Supprimer les journées du tournoi
        Journer::where('tournoi_id', $tournoiId)->delete();

        // Supprimer les classements du tournoi
        Classement::where('tournoi_id', $tournoiId)->delete();

        return redirect()->back()->with('success', 'Tournoi réinitialisé avec succès !');
    }

    /**
     * Ancienne méthode reset globale (à garder pour compatibilité)
     */
    public function reset()
    {
        // Supprimer les journées
        Journer::truncate();

        // Réinitialiser les classements
        Classement::query()->update([
            'mj' => 0,
            'g'  => 0,
            'n'  => 0,
            'p'  => 0,
            'bp' => 0,
            'bc' => 0,
            'points' => 0,
        ]);

        return back()->with('success', 'Tournoi réinitialisé avec succès ✔️');
    }

    public function phaseFinale()
    {
        // prendre top 8
        $top8 = Classement::with('inscrit')
            ->orderBy('points', 'DESC')
            ->orderByRaw('(bp - bc) DESC')
            ->orderBy('bp', 'DESC')
            ->take(8)
            ->get();

        return view('Admin.phase-finale', compact('top8'));
    }

  // Liste des tournois pour la gestion des participants
public function listeTournoisParticipants()
{
    $tournois = Tournois::latest()->get();
    return view('admin.tournois-participants', compact('tournois'));
}

// Participants d'un tournoi spécifique

public function participantsParTournoi($tournoiId)
{
    $tournoi = Tournois::findOrFail($tournoiId);

    // CORRECTION : Récupérer les participants QUI ONT ENVOYÉ DES CAPTURES pour ce tournoi
    $inscritsIds = \App\Models\Envoyer::where('tournoi_id', $tournoiId)
                     ->pluck('inscrit_id')
                     ->unique()
                     ->toArray();

    $inscrits = Inscrit::whereIn('id', $inscritsIds)
                 ->where('authorized', true)
                 ->get();

    // Ou si vous voulez tous les participants autorisés (même sans captures) :
    // $inscrits = Inscrit::where('authorized', true)->get();

    $tournois = Tournois::all();

    return view('inscrit.attente', compact('inscrits', 'tournois', 'tournoi'));
}

}
