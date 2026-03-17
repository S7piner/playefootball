<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournois extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'image',
        'description',
        'date',
        'caution',
    ];

    public function commencers()
    {
        return $this->hasMany(Commencer::class);
    }

    public function envoyers()
    {
        return $this->hasMany(Envoyer::class);
    }
}
