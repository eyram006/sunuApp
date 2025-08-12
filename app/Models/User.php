<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'client_id',
        'password_changed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'password_changed_at' => 'datetime',
        ];
    }

    /**
     * Vérifier si l'utilisateur doit changer son mot de passe
     */
    public function mustChangePassword()
    {
        return is_null($this->password_changed_at);
    }

    /**
     * Marquer le mot de passe comme changé
     */
    public function markPasswordAsChanged()
    {
        $this->update(['password_changed_at' => now()]);
    }

    /**
     * Relation avec le client (entreprise)
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation avec l'assuré
     */
    public function assure()
    {
        return $this->hasOne(Assure::class);
    }

    /**
     * Relation avec les demandes traitées (pour les gestionnaires)
     */
    public function demandesTraitees()
    {
        return $this->hasMany(Demande::class, 'gestionnaire_id');
    }
}
