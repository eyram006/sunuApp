<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'assure_id',
        'gestionnaire_id',
        'statut',
        'pieces_justificatives',
        'commentaires_gestionnaire',
        'date_traitement'
    ];

    protected $casts = [
        'date_traitement' => 'datetime',
    ];

    /**
     * Relation avec l'assuré
     */
    public function assure()
    {
        return $this->belongsTo(Assure::class);
    }

    /**
     * Relation avec le gestionnaire
     */
    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    /**
     * Scope pour les demandes en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope pour les demandes validées
     */
    public function scopeValidees($query)
    {
        return $query->where('statut', 'validee');
    }

    /**
     * Scope pour les demandes rejetées
     */
    public function scopeRejetees($query)
    {
        return $query->where('statut', 'rejetee');
    }
}
