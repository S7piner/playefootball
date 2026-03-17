<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <- important
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscrit extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'inscrits'; // ton tableau personnalisé

    protected $fillable = [
        'nom',
        'prenom',
        'pseudo',
        'telephone',
        'email',
        'pays',
        'password',
        'authorized',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function envoyers()
    {
        return $this->hasMany(Envoyer::class);
    }

     public function tournoi()
    {
        return $this->belongsTo(Tournois::class, 'tournoi_id');
    }
}
