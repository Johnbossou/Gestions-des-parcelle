<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les permissions avec guard_name = web
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
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['guard_name' => 'web']
            );
        }

        // Créer les rôles avec guard_name = web
        $roleChef = Role::updateOrCreate(
            ['name' => 'chef_service', 'guard_name' => 'web'],
            ['guard_name' => 'web']
        );
        $roleChef->syncPermissions([
            'create-parcelles',
            'edit-parcelles',
            'delete-parcelles',
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'edit-coordinates',
            'manage-litiges',
            'view-structure',
        ]);

        $roleSecretaire = Role::updateOrCreate(
            ['name' => 'secretaire_executif', 'guard_name' => 'web'],
            ['guard_name' => 'web']
        );
        $roleSecretaire->syncPermissions([
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'view-structure',
        ]);

        $roleDSI = Role::updateOrCreate(
            ['name' => 'dsi', 'guard_name' => 'web'],
            ['guard_name' => 'web']
        );
        $roleDSI->syncPermissions([
            'manage-users',
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'view-structure',
        ]);
    }
}
