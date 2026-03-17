<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journer extends Model
{
    use HasFactory;
    protected $table = 'journers';

    protected $fillable = [
        'numero_journee',
        'tournoi_id',
        'joueur1_id',
        'joueur2_id',
        'score_joueur1',
        'score_joueur2',
        'date_match',
        'statut'
    ];

    public function joueur1()
    {
        return $this->belongsTo(Inscrit::class, 'joueur1_id');
    }

    public function joueur2()
    {
        return $this->belongsTo(Inscrit::class, 'joueur2_id');
    }

    public function tournoi()
    {
        return $this->belongsTo(Tournois::class, 'tournoi_id');
    }
}
