<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rendezVous extends Model
{
    protected $fillable = [
        'patient_id',
        'medecin_id',
        'date',
        'heure',
        'motif',
        'statut',
        'symptomes',
        'niveau_douleur',
        'allergies',
        'medicaments_en_cours'
    ];
    protected $casts = [
        'statut' => StatutRdv::class,
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
}
