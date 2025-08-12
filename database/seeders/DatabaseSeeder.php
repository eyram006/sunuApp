<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Assure;
use App\Models\Demande;
use App\Models\Gestionnaire;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer les rôles et permissions
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Créer l'utilisateur admin
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@sunusante.com',
            'password' => Hash::make('password'),
            'password_changed_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Créer un client exemple
        $client = Client::create([
            'nom_entreprise' => 'Entreprise Exemple SARL',
            'adresse' => '123 Avenue de la Paix, Lomé',
            'telephone' => '+228 90123456',
            'email' => 'contact@entreprise-exemple.tg',
            'token_acces' => 'token_' . Str::random(32),
            'statut' => 'actif',
        ]);

        // Créer des assurés exemple
        $assure = Assure::create([
            'user_id' => $admin->id, // Utiliser l'admin comme user_id temporaire
            'client_id' => $client->id,
            'nom' => 'Doe',
            'prenoms' => 'John',
            'date_de_naissance' => '1985-06-15',
            'sexe' => 'M',
            'contact' => '+228 90123457',
            'addresse' => '456 Rue du Commerce, Lomé',
            'anciennete' => '5 ans',
            'statut' => 'actif',
            'type' => 'principal',
        ]);

        // Créer des demandes exemple
        Demande::create([
            'assure_id' => $assure->id,
            'gestionnaire_id' => null,
            'statut' => 'en_attente',
            'pieces_justificatives' => 'Carte d\'identité, justificatif de domicile',
            'commentaires_gestionnaire' => null,
            'date_traitement' => null,
        ]);

        // Créer des gestionnaires
        $this->call([
            GestionnaireSeeder::class,
        ]);
    }
}
