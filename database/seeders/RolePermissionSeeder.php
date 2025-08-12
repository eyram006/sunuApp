<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les permissions
        $permissions = [
            'gestion_utilisateurs',
            'traitement_demandes',
            'creation_demandes',
            'consultation_donnees',
            'gestion_clients',
            'gestion_assures',
            'gestion_beneficiaires',
            'generation_cartes',
            'import_excel',
            'export_excel'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Créer les rôles
        $adminRole = Role::create(['name' => 'admin']);
        $gestionnaireRole = Role::create(['name' => 'gestionnaire']);
        $assureRole = Role::create(['name' => 'assure']);

        // Attribuer les permissions aux rôles
        $adminRole->givePermissionTo(Permission::all());

        $gestionnaireRole->givePermissionTo([
            'traitement_demandes',
            'consultation_donnees',
            'gestion_assures',
            'gestion_beneficiaires',
            'generation_cartes',
            'export_excel'
        ]);

        $assureRole->givePermissionTo([
            'creation_demandes',
            'consultation_donnees'
        ]);
    }
}
