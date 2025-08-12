<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gestionnaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nom',
        'prenoms',
        'email',
        'telephone',
        'statut',
        'notes',
    ];

    protected $casts = [
        'statut' => 'string',
    ];

    // Statuts possibles
    const STATUT_ACTIF = 'actif';
    const STATUT_INACTIF = 'inactif';
    const STATUT_SUSPENDU = 'suspendu';
    const STATUT_EN_CONGE = 'en_conge';

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les entreprises gérées (many-to-many)
     */
    public function entreprises()
    {
        return $this->belongsToMany(Client::class, 'gestionnaire_entreprise', 'gestionnaire_id', 'client_id')
                    ->withTimestamps();
    }

    /**
     * Relation avec les assurés gérés
     */
    public function assures()
    {
        return $this->hasMany(Assure::class, 'gestionnaire_id');
    }

    /**
     * Relation avec les demandes traitées
     */
    public function demandes()
    {
        return $this->hasMany(Demande::class, 'gestionnaire_id');
    }

    /**
     * Obtenir le nom complet
     */
    public function getNomCompletAttribute()
    {
        return $this->prenoms . ' ' . $this->nom;
    }

    /**
     * Vérifier si le gestionnaire est actif
     */
    public function isActif(): bool
    {
        return $this->statut === 'actif';
    }

    /**
     * Vérifier si le gestionnaire est récemment actif
     */
    public function isRecemmentActif(): bool
    {
        return $this->statut === 'actif';
    }

    /**
     * Obtenir le nombre d'assurés gérés
     */
    public function getNombreAssuresAttribute()
    {
        return $this->assures()->count();
    }

    /**
     * Obtenir le nombre de demandes traitées
     */
    public function getNombreDemandesAttribute()
    {
        return $this->demandes()->count();
    }

    /**
     * Obtenir le nombre d'entreprises gérées
     */
    public function getNombreEntreprisesAttribute()
    {
        return $this->entreprises()->count();
    }

    /**
     * Vérifier si le gestionnaire gère une entreprise spécifique
     */
    public function gereEntreprise($clientId)
    {
        return $this->entreprises()->where('client_id', $clientId)->exists();
    }

    /**
     * Scope pour les gestionnaires actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('statut', self::STATUT_ACTIF);
    }

    /**
     * Scope pour les gestionnaires récemment actifs
     */
    public function scopeRecemmentActifs($query)
    {
        return $query->where('derniere_connexion', '>=', now()->subDays(7));
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeParStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    /**
     * Scope pour la recherche
     */
    public function scopeRecherche($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('prenoms', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }
}
