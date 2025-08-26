<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

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
            'create-view-users',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['guard_name' => 'web']
            );
        }

        // 1. Rôle chef_service (ancien Superviseur_administratif)
        $roleChefService = Role::updateOrCreate(
            ['name' => 'chef_service', 'guard_name' => 'web'],
            ['guard_name' => 'web']
        );
        $roleChefService->syncPermissions([
            'create-parcelles',
            'edit-parcelles',
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'edit-coordinates',
            'manage-litiges',
            'view-structure',
        ]);

        // 2. Rôle secretaire_executif (distinct de Consultant)
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

        // 3. Rôle Consultant (distinct de secretaire_executif)
        $roleConsultant = Role::updateOrCreate(
            ['name' => 'Consultant', 'guard_name' => 'web'],
            ['guard_name' => 'web']
        );
        $roleConsultant->syncPermissions([
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'view-structure',
        ]);

        // 4. Rôle dsi (ancien Administrateur)
        $roleDsi = Role::updateOrCreate(
            ['name' => 'dsi', 'guard_name' => 'web'],
            ['guard_name' => 'web']
        );
        $roleDsi->syncPermissions([
            'manage-users',
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'view-structure',
        ]);

        // 5. Rôle chef_division (ancien Chef_Administratif)
        $roleChefDivision = Role::updateOrCreate(
            ['name' => 'chef_division', 'guard_name' => 'web'],
            ['guard_name' => 'web']
        );
        $roleChefDivision->syncPermissions([
            'create-parcelles',
            'view-parcels',
            'export-parcels',
            'filter-sort-parcels',
            'edit-coordinates',
            'manage-litiges',
            'view-structure',
        ]);

        // 6. Rôle Directeur
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

        // Migration des associations utilisateurs (optionnel mais recommandé)
        $this->migrateUserRoles();
    }

    protected function migrateUserRoles(): void
    {
        $roleMappings = [
            'Superviseur_administratif' => 'chef_service',
            'Administrateur' => 'dsi',
            'Chef_Administratif' => 'chef_division',
            // secretaire_executif et Consultant restent inchangés
        ];

        foreach ($roleMappings as $oldRole => $newRole) {
            $users = User::whereHas('roles', function($query) use ($oldRole) {
                $query->where('name', $oldRole);
            })->get();

            foreach ($users as $user) {
                $user->assignRole($newRole);
                $user->removeRole($oldRole);
            }
        }
    }
}
