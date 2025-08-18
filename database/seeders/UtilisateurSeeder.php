<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@mairie.bj',
                'password' => Hash::make('password123'),
                'role' => 'Superviseur_administratif', // Ancien: chef_service
            ],
            [
                'name' => 'Marie Koffi',
                'email' => 'marie.koffi@mairie.bj',
                'password' => Hash::make('password123'),
                'role' => 'Consultant', // Ancien: secretaire_executif
            ],
            [
                'name' => 'Paul Ahomadegbe',
                'email' => 'paul.dsi@mairie.bj',
                'password' => Hash::make('password123'),
                'role' => 'Administrateur', // Ancien: dsi
            ],
            [
                'name' => 'Aline Sossou',
                'email' => 'aline.sossou@mairie.bj',
                'password' => Hash::make('password123'),
                'role' => 'Superviseur_administratif', // Ancien: chef_service
            ],
            [
                'name' => 'Sophie Gbedji',
                'email' => 'sophie.gbedji@mairie.bj',
                'password' => Hash::make('password123'),
                'role' => 'Chef_Administratif', // Ancien: chef_division
            ],
            [
                'name' => 'Koffi Mensah', // Nouvel utilisateur Directeur
                'email' => 'koffi.mensah@mairie.bj',
                'password' => Hash::make('DirectorPass123!'), // Mot de passe plus robuste pour le Directeur
                'role' => 'Directeur',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::where('email', $userData['email'])->first();

            if (!$user) {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ]);
            }

            $role = Role::firstOrCreate(
                ['name' => $userData['role'], 'guard_name' => 'web']
            );

            if (!$user->hasRole($role->name)) {
                $user->assignRole($role);
            }
        }
    }
}
