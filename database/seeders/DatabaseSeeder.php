<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Rôles et permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // Utilisateurs
        $this->call(UtilisateurSeeder::class);

        // Parcelles
        $this->call(ParcelleSeeder::class);

        // Journal d'audit
        $this->call(AuditLogSeeder::class);
    }
}
