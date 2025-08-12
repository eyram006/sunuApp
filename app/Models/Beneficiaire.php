<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beneficiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'assure_principal_id',
        'nom',
        'prenoms',
        'sexe',
        'contact',
        'addresse',
        'date_de_naissance',
        'type_beneficiaire',
        'statut'
    ];

    protected $casts = [
        'date_de_naissance' => 'date',
    ];

    /**
     * Relation avec l'assuré principal
     */
    public function assurePrincipal()
    {
        return $this->belongsTo(Assure::class, 'assure_principal_id');
    }

    /**
     * Nom complet du bénéficiaire
     */
    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenoms;
    }
}
