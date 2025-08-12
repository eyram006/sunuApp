<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un client d'exemple
        Client::create([
            'nom_entreprise' => 'Entreprise Test SARL',
            'adresse' => '123 Avenue de la Paix, Lomé, Togo',
            'telephone' => '+228 22 22 22 22',
            'email' => 'contact@entreprisetest.tg',
            'token_acces' => Client::generateToken(),
            'statut' => 'actif'
        ]);

        $this->command->info('Client d\'exemple créé avec succès !');
    }
}
