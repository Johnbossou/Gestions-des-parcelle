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
                'role' => 'chef_service',
            ],
            [
                'name' => 'Marie Koffi',
                'email' => 'marie.koffi@mairie.bj',
                'password' => Hash::make('password123'),
                'role' => 'secretaire_executif',
            ],
            [
                'name' => 'Paul Ahomadegbe',
                'email' => 'paul.dsi@mairie.bj',
                'password' => Hash::make('password123'),
                'role' => 'dsi',
            ],
            [
                'name' => 'Aline Sossou',
                'email' => 'aline.sossou@mairie.bj',
                'password' => Hash::make('password123'),
                'role' => 'chef_service',
            ],
            [
                'name' => 'Sophie Gbedji', // Nouvel ajout
                'email' => 'sophie.gbedji@mairie.bj',
                'password' => Hash::make('password123'),
                'role' => 'chef_division',
            ],
        ];

        foreach ($users as $userData) {
            // Vérifier si l'utilisateur existe déjà
            $user = User::where('email', $userData['email'])->first();

            if (!$user) {
                // Si l'utilisateur n'existe pas, on le crée
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ]);
            }

            // Créer ou récupérer le rôle
            $role = Role::firstOrCreate(['name' => $userData['role'], 'guard_name' => 'web']);

            // Assigner le rôle seulement si l'utilisateur ne l'a pas déjà
            if (!$user->hasRole($role->name)) {
                $user->assignRole($role);
            }
        }
    }
}
