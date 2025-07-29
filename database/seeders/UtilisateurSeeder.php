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
                'password' => Hash::make  ('password123'),
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
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
            $user->assignRole(Role::findByName($userData['role'], 'web'));
        }
    }
}
