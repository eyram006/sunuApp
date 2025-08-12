<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gestionnaire;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class GestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer le premier client (entreprise)
        $client = Client::first();
        
        if (!$client) {
            $this->command->error('Aucun client trouvé. Veuillez d\'abord exécuter ClientSeeder.');
            return;
        }

        $gestionnaires = [
            [
                'nom' => 'Konan',
                'prenoms' => 'Jean-Pierre',
                'email' => 'jean.konan@sunusante.com',
                'telephone' => '+228 90123456',
                'statut' => 'actif',
                'notes' => 'Gestionnaire principal, expérimenté',
            ],
            [
                'nom' => 'Adjo',
                'prenoms' => 'Marie-Claire',
                'email' => 'marie.adjo@sunusante.com',
                'telephone' => '+228 90123457',
                'statut' => 'actif',
                'notes' => 'Spécialiste des PME',
            ],
            [
                'nom' => 'Tchakounte',
                'prenoms' => 'François',
                'email' => 'francois.tchakounte@sunusante.com',
                'telephone' => '+228 90123458',
                'statut' => 'inactif',
                'notes' => 'En formation',
            ],
            [
                'nom' => 'Kouassi',
                'prenoms' => 'Agnès',
                'email' => 'agnes.kouassi@sunusante.com',
                'telephone' => '+228 90123459',
                'statut' => 'actif',
                'notes' => 'Gestionnaire junior',
            ],
        ];

        foreach ($gestionnaires as $gestionnaireData) {
            $user = User::create([
                'name' => $gestionnaireData['prenoms'] . ' ' . $gestionnaireData['nom'],
                'email' => $gestionnaireData['email'],
                'password' => Hash::make('password123'),
                'password_changed_at' => now(),
            ]);
            $user->assignRole('gestionnaire');
            
            $gestionnaire = Gestionnaire::create([
                'user_id' => $user->id,
                'nom' => $gestionnaireData['nom'],
                'prenoms' => $gestionnaireData['prenoms'],
                'email' => $gestionnaireData['email'],
                'telephone' => $gestionnaireData['telephone'],
                'statut' => $gestionnaireData['statut'],
                'notes' => $gestionnaireData['notes'],
            ]);
        }

        $this->command->info('Gestionnaires créés avec succès !');
        $this->command->info('Emails: jean.konan@sunusante.com, marie.adjo@sunusante.com, francois.tchakounte@sunusante.com, agnes.kouassi@sunusante.com');
        $this->command->info('Mot de passe pour tous: password123');
    }
}
