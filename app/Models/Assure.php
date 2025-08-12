<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assure extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'nom',
        'prenoms',
        'sexe',
        'contact',
        'addresse',
        'date_de_naissance',
        'anciennete',
        'statut',
        'type'
    ];

    protected $casts = [
        'date_de_naissance' => 'date',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le client (entreprise)
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation avec les bénéficiaires
     */
    public function beneficiaires()
    {
        return $this->hasMany(Beneficiaire::class, 'assure_principal_id');
    }

    /**
     * Relation avec les demandes
     */
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    /**
     * Relation avec les cartes
     */
    public function cartes()
    {
        return $this->hasMany(Carte::class);
    }

    /**
     * Nom complet de l'assuré
     */
    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenoms;
    }
}
