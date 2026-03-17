<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classement extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournoi_id',
        'inscrit_id',
        'mj',
        'g',
        'n',
        'p',
        'bp',       // ← AJOUTER
        'bc',
        'dif',      // ← AJOUTER
        'points'
    ];

    public function inscrit()
    {
        return $this->belongsTo(Inscrit::class, 'inscrit_id');
    }

    public function tournoi()
    {
        return $this->belongsTo(Tournois::class, 'tournoi_id');
    }

    // Méthode pour calculer automatiquement la différence
    public function calculerDifference()
    {
        $this->dif = $this->bp - $this->bc;
        return $this->dif;
    }

    // Méthode pour récupérer les derniers matchs
    public function derniersMatchs()
    {
        return Journer::where(function($query) {
            $query->where('joueur1_id', $this->inscrit_id)
                  ->orWhere('joueur2_id', $this->inscrit_id);
        })
        ->where('statut', 'termine')
        ->orderBy('created_at', 'DESC')
        ->limit(5)
        ->get();
    }
}
