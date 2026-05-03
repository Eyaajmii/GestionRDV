<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\RendezVous;

class Medecin extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'specialite',
        'telephone',
        'emailPro',
        'horaires_disponibles'
    ];

    protected $casts = [
        'horaires_disponibles' => 'array'
    ];

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}