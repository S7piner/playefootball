<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tournoi_id',
        'preuve',
        'statut',
    ];

    public function tournois()
    {
        return $this->belongsTo(Tournois::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
