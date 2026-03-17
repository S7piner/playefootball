<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhaseFinale extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournoi_id',
        'round',
        'player1_id',
        'player2_id',
        'score1',
        'score2',
        'winner_id',
        'order'
    ];

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
