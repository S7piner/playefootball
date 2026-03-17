<?php

namespace App\Http\Controllers;

use App\Models\Classement;
use App\Models\PhaseFinaleMatch;
use App\Models\Tournois;
use Illuminate\Http\Request;

class PhaseFinaleController extends Controller
{

    



    public function show($tournoi_id = null)
{
    // Si aucun tournoi n'est spécifié, rediriger vers la liste
    if (!$tournoi_id) {
        return redirect()->route('admin.phase-finale-liste');
    }

    // Récupérer les 8 meilleurs joueurs POUR CE TOURNOI
    $top8 = Classement::where('tournoi_id', $tournoi_id)
        ->with('inscrit')
        ->orderBy('points', 'DESC')
        ->orderByRaw('(bp - bc) DESC')
        ->orderBy('bp', 'DESC')
        ->take(8)
        ->get();

    // Récupérer les matchs de phase finale POUR CE TOURNOI
    $quarters = PhaseFinaleMatch::where('tournoi_id', $tournoi_id)
        ->where('round', 'quarter')
        ->with(['player1', 'player2', 'winner'])
        ->orderBy('order')
        ->get();

    $semis = PhaseFinaleMatch::where('tournoi_id', $tournoi_id)
        ->where('round', 'semi')
        ->with(['player1', 'player2', 'winner'])
        ->orderBy('order')
        ->get();

    $final = PhaseFinaleMatch::where('tournoi_id', $tournoi_id)
        ->where('round', 'final')
        ->with(['player1', 'player2', 'winner'])
        ->first();

    $tournoi = \App\Models\Tournois::find($tournoi_id);

    return view('Admin.phase-finale', compact(
        'top8',
        'quarters',
        'semis',
        'final',
        'tournoi_id',
        'tournoi'
    ));
}

    public function generate($tournoi_id)
    {
        $top8 = Classement::where('tournoi_id', $tournoi_id)
            ->with('inscrit')
            ->orderBy('points', 'DESC')
            ->orderByRaw('(bp - bc) DESC')
            ->orderBy('bp', 'DESC')
            ->take(8)
            ->get();

        if ($top8->count() < 8) {
            return redirect()->back()->with('error', 'Il faut 8 participants pour la phase finale');
        }

        // Supprimer les anciens matchs si existants
        PhaseFinaleMatch::where('tournoi_id', $tournoi_id)->delete();

        // Créer les quarts de finale
        for ($i = 0; $i < 8; $i += 2) {
            PhaseFinaleMatch::create([
                'tournoi_id' => $tournoi_id,
                'round'      => 'quarter',
                'player1_id' => $top8[$i]->inscrit_id,
                'player2_id' => $top8[$i+1]->inscrit_id,
                'order'      => $i/2,
            ]);
        }

        return redirect()->route('admin.phase-finale', $tournoi_id)
                        ->with('success', 'Phase finale générée avec succès !');
    }

    public function validateMatch(Request $request, $match_id)
    {
        $match = PhaseFinaleMatch::findOrFail($match_id);

        $request->validate([
            'score1_aller' => 'required|integer|min:0',
            'score2_aller' => 'required|integer|min:0',
            'score1_retour' => 'required|integer|min:0',
            'score2_retour' => 'required|integer|min:0'
        ]);

        // Sauvegarder les scores aller-retour
        $match->score1_aller = $request->score1_aller;
        $match->score2_aller = $request->score2_aller;
        $match->score1_retour = $request->score1_retour;
        $match->score2_retour = $request->score2_retour;

        // Calculer les totaux
        $match->score_total1 = $request->score1_aller + $request->score1_retour;
        $match->score_total2 = $request->score2_aller + $request->score2_retour;

        // Déterminer le vainqueur
        if ($match->score_total1 > $match->score_total2) {
            $match->winner_id = $match->player1_id;
        } elseif ($match->score_total2 > $match->score_total1) {
            $match->winner_id = $match->player2_id;
        } else {
            $match->winner_id = null;
        }

        $match->save();

        // Générer les tours suivants si un vainqueur est déterminé
        if ($match->winner_id) {
            if ($match->round === 'quarter') {
                $this->generateSemi($match->tournoi_id);
            }

            if ($match->round === 'semi') {
                $this->generateFinal($match->tournoi_id);
            }
        }

        return back()->with('success', 'Scores aller-retour validés ✔️');
    }

    private function generateSemi($tournoi_id)
    {
        $winners = PhaseFinaleMatch::where('tournoi_id', $tournoi_id)
            ->where('round', 'quarter')
            ->whereNotNull('winner_id')
            ->orderBy('order')
            ->get();

        if ($winners->count() !== 4) return;

        $existingSemis = PhaseFinaleMatch::where('tournoi_id', $tournoi_id)
            ->where('round', 'semi')
            ->count();

        if ($existingSemis === 0) {
            PhaseFinaleMatch::create([
                'tournoi_id' => $tournoi_id,
                'round'      => 'semi',
                'player1_id' => $winners[0]->winner_id,
                'player2_id' => $winners[1]->winner_id,
                'order'      => 0,
            ]);

            PhaseFinaleMatch::create([
                'tournoi_id' => $tournoi_id,
                'round'      => 'semi',
                'player1_id' => $winners[2]->winner_id,
                'player2_id' => $winners[3]->winner_id,
                'order'      => 1,
            ]);
        }
    }

    private function generateFinal($tournoi_id)
    {
        $winners = PhaseFinaleMatch::where('tournoi_id', $tournoi_id)
            ->where('round', 'semi')
            ->whereNotNull('winner_id')
            ->orderBy('order')
            ->get();

        if ($winners->count() !== 2) return;

        $existingFinal = PhaseFinaleMatch::where('tournoi_id', $tournoi_id)
            ->where('round', 'final')
            ->count();

        if ($existingFinal === 0) {
            PhaseFinaleMatch::create([
                'tournoi_id' => $tournoi_id,
                'round'      => 'final',
                'player1_id' => $winners[0]->winner_id,
                'player2_id' => $winners[1]->winner_id,
                'order'      => 0,
            ]);
        }
    }

    public function listeTournois()
{
    $tournois = \App\Models\Tournois::latest()->get();
    return view('Admin.phase-finale-liste', compact('tournois'));
}
}
