<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les permissions avec guard_name = web (inchangées)
        $permissions = [
            'create-parcelles',
            'edit-parcelles',
            'delete-parcelles',
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'edit-coordinates',
            'manage-users',
            'manage-litiges',
            'view-structure',
            'create-view-users',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['guard_name' => 'web']
            );
        }

        // Rôles mis à jour selon vos instructions
        $roleSuperviseur = Role::updateOrCreate(
            ['name' => 'Superviseur_administratif', 'guard_name' => 'web'], // Ancien: chef_service
            ['guard_name' => 'web']
        );
        $roleSuperviseur->syncPermissions([
            'create-parcelles',
            'edit-parcelles',
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'edit-coordinates',
            'manage-litiges',
            'view-structure',
        ]);

        $roleConsultant = Role::updateOrCreate(
            ['name' => 'Consultant', 'guard_name' => 'web'], // Ancien: secretaire_executif
            ['guard_name' => 'web']
        );
        $roleConsultant->syncPermissions([
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'view-structure',
        ]);

        $roleAdministrateur = Role::updateOrCreate(
            ['name' => 'Administrateur', 'guard_name' => 'web'], // Ancien: dsi
            ['guard_name' => 'web']
        );
        $roleAdministrateur->syncPermissions([
            'manage-users',
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'view-structure',
        ]);

        $roleChefAdmin = Role::updateOrCreate(
            ['name' => 'Chef_Administratif', 'guard_name' => 'web'], // Ancien: chef_division
            ['guard_name' => 'web']
        );
        $roleChefAdmin->syncPermissions([
            'create-parcelles',
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'edit-coordinates',
            'manage-litiges',
            'view-structure',
        ]);

        // Ajout du nouveau rôle Directeur (avec mêmes permissions que Consultant)
        $roleDirecteur = Role::updateOrCreate(
            ['name' => 'Directeur', 'guard_name' => 'web'],
            ['guard_name' => 'web']
        );
        $roleDirecteur->syncPermissions([
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'view-structure',
        ]);
    }
}
