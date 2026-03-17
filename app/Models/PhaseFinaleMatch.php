<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhaseFinaleMatch extends Model
{
    use HasFactory;

    protected $table = 'phase_finale_matchs';

    protected $fillable = [
        'tournoi_id',
        'round',
        'player1_id',
        'player2_id',
        'score1_aller',
        'score2_aller',
        'score1_retour',
        'score2_retour',
        'score_total1',
        'score_total2',
        'winner_id',
        'order'
    ];

    public function tournoi()
    {
        return $this->belongsTo(Tournois::class);
    }

    public function player1()
    {
        return $this->belongsTo(Inscrit::class, 'player1_id');
    }

    public function player2()
    {
        return $this->belongsTo(Inscrit::class, 'player2_id');
    }

    public function winner()
    {
        return $this->belongsTo(Inscrit::class, 'winner_id');
    }
}
