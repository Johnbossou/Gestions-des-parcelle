<?php
namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        // S'assurer que les rôles et permissions existent
        $this->call(RolesAndPermissionsSeeder::class);

        $users = [
            [
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@mairie.bj',
                'password' => Hash::make('azerty12àA'),
            ],
            [
                'name' => 'Marie Koffi',
                'email' => 'marie.koffi@mairie.bj',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Paul Ahomadegbe',
                'email' => 'paul.dsi@mairie.bj',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Aline Sossou',
                'email' => 'aline.sossou@mairie.bj',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Sophie Gbedji',
                'email' => 'sophie.gbedji@mairie.bj',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Koffi Mensah',
                'email' => 'koffi.mensah@mairie.bj',
                'password' => Hash::make('DirectorPass123!'),
            ],
        ];

        $roles = [
            'jean.dupont@mairie.bj' => 'chef_service',
            'marie.koffi@mairie.bj' => 'Consultant',
            'paul.dsi@mairie.bj' => 'dsi',
            'aline.sossou@mairie.bj' => 'chef_service',
            'sophie.gbedji@mairie.bj' => 'chef_division',
            'koffi.mensah@mairie.bj' => 'Directeur',
        ];

        foreach ($users as $userData) {
            $user = Utilisateur::where('email', $userData['email'])->first();

            if (!$user) {
                $user = Utilisateur::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ]);
            }

            // Assigner le rôle correspondant
            $roleName = $roles[$userData['email']];
            $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();
            if ($role && !$user->hasRole($role->name)) {
                $user->assignRole($role);
            }
        }
    }
}
