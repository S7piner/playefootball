<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commencer extends Model
{
    use HasFactory;

    //  protected $table = 'commencers';

     protected $fillable = [
        'inscrit_id',
        'tournoi_id',
        'image',
        'status',
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
