<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer l'utilisateur administrateur
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@sunusante.com',
            'password' => Hash::make('password'),
        ]);

        // Attribuer le rôle admin
        $admin->assignRole('admin');

        // Créer un gestionnaire d'assurance
        $gestionnaire = User::create([
            'name' => 'Gestionnaire Assurance',
            'email' => 'gestionnaire@sunusante.com',
            'password' => Hash::make('password'),
        ]);

        // Attribuer le rôle gestionnaire
        $gestionnaire->assignRole('gestionnaire');

        $this->command->info('Utilisateurs par défaut créés avec succès !');
        $this->command->info('Admin: admin@sunusante.com / password');
        $this->command->info('Gestionnaire: gestionnaire@sunusante.com / password');
    }
}
