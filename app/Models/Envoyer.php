<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envoyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscrit_id',
        'tournoi_id',
        'image',
    ];

     public function inscrit()
    {
        return $this->belongsTo(Inscrit::class);
    }

    public function tournoi()
    {
        return $this->belongsTo(Tournois::class);
    }
}
