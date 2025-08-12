<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_entreprise',
        'adresse',
        'telephone',
        'email',
        'token_acces',
        'statut'
    ];

    /**
     * Relation avec les utilisateurs
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relation avec les assurés
     */
    public function assures()
    {
        return $this->hasMany(Assure::class);
    }

    /**
     * Générer un token d'accès unique
     */
    public static function generateToken()
    {
        return 'token_' . uniqid() . '_' . time();
    }
}
