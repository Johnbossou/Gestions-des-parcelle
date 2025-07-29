<?php
namespace Database\Seeders;

use App\Models\Parcelle;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParcelleSeeder extends Seeder
{
    public function run(): void
    {
        $arrondissements = ['Godomey', 'Akassato', 'Zinvié', 'Togba', 'Ouèdo', 'Hêvié', 'Kpanroun', 'Calavi-Centre'];
        $secteurs = ['Centre', 'Nord', 'Sud', 'Est', 'Ouest'];
        $types_terrain = ['Résidentiel', 'Commercial', 'Agricole', 'Institutionnel', 'Autre'];
        $statuts = ['attribué', 'non attribué'];
        $motifs = ['Correction superficie', 'Mise à jour cadastrale', 'Litige résolu', 'Relevés GPS', 'Aucune modification'];
        $structures = [null, 'Ministère de l\'Éducation', 'École publique', 'Marché local', 'Centre de santé'];
        $litiges = [null, true, false];

        $userIds = User::pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $ancienne_superficie = rand(100, 2000) / 10;
            $nouvelle_superficie = rand(100, 2000) / 10;
            $litige = $litiges[array_rand($litiges)];

            Parcelle::create([
                'numero' => $i,
                'arrondissement' => $arrondissements[array_rand($arrondissements)],
                'secteur' => $secteurs[array_rand($secteurs)],
                'lot' => rand(1, 100),
                'designation' => 'Parcelle ' . Str::random(5),
                'parcelle' => 'PAR-' . Str::padLeft($i, 4, '0'),
                'ancienne_superficie' => $ancienne_superficie,
                'nouvelle_superficie' => $nouvelle_superficie,
                'ecart_superficie' => round($nouvelle_superficie - $ancienne_superficie, 2),
                'motif' => $motifs[array_rand($motifs)],
                'observations' => $litige === true ? 'Litige en cours, voir détails' : ($litige === false ? 'Aucune observation' : 'Données incomplètes'),
                'type_terrain' => $types_terrain[array_rand($types_terrain)],
                'statut_attribution' => $statuts[array_rand($statuts)],
                'litige' => $litige,
                'details_litige' => $litige === true ? 'Conflit avec propriétaire adjacent' : null,
                'structure' => $structures[array_rand($structures)],
                'date_mise_a_jour' => now()->subDays(rand(0, 365)),
                'latitude' => 6.35 + (rand(-100, 100) / 10000),
                'longitude' => 2.35 + (rand(-100, 100) / 10000),
                'agent' => !empty($userIds) ? $userIds[array_rand($userIds)] : null,
                'responsable_id' => !empty($userIds) ? $userIds[array_rand($userIds)] : null,
                'updated_by' => !empty($userIds) ? $userIds[array_rand($userIds)] : 1,
                'created_by' => !empty($userIds) ? $userIds[array_rand($userIds)] : 1,
            ]);
        }
    }
}
