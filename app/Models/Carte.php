<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carte extends Model
{
    use HasFactory;

    protected $fillable = [
        'assure_id',
        'numero_carte',
        'date_emission',
        'date_expiration',
        'statut',
        'informations_supplementaires'
    ];

    protected $casts = [
        'date_emission' => 'date',
        'date_expiration' => 'date',
    ];

    /**
     * Relation avec l'assuré
     */
    public function assure()
    {
        return $this->belongsTo(Assure::class);
    }

    /**
     * Générer un numéro de carte unique
     */
    public static function generateNumeroCarte()
    {
        return 'CARTE_' . uniqid() . '_' . time();
    }

    /**
     * Vérifier si la carte est expirée
     */
    public function isExpiree()
    {
        return $this->date_expiration->isPast();
    }

    /**
     * Vérifier si la carte est active
     */
    public function isActive()
    {
        return $this->statut === 'active' && !$this->isExpiree();
    }
}
