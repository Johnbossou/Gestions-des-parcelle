<?php
namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Parcelle;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id')->toArray();
        $parcelles = Parcelle::pluck('id')->toArray();
        $actions = ['create', 'update', 'delete'];
        $fields = ['nouvelle_superficie', 'litige', 'structure', 'type_terrain'];

        for ($i = 1; $i <= 20; $i++) {
            AuditLog::create([
                'user_id' => $users[array_rand($users)],
                'action' => $actions[array_rand($actions)],
                'model_type' => 'Parcelle',
                'model_id' => $parcelles[array_rand($parcelles)],
                'changes' => json_encode([
                    'field' => $fields[array_rand($fields)],
                    'old_value' => rand(100, 1000) / 10,
                    'new_value' => rand(100, 1000) / 10,
                ]),
                'created_at' => now()->subDays(rand(0, 365)),
                'updated_at' => now()->subDays(rand(0, 365)),
            ]);
        }
    }
}
