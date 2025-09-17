<?php

namespace Database\Seeders;

use App\Models\Parcelle;
use App\Models\Utilisateur; // ← Modifier ici: User -> Utilisateur
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ParcelleSeeder extends Seeder
{
    public function run(): void
    {
        $arrondissements = ['Godomey', 'Akassato', 'Zinvié', 'Togba', 'Ouèdo', 'Hêvié', 'Kpanroun', 'Calavi-Centre'];
        $secteurs = ['Centre', 'Nord', 'Sud', 'Est', 'Ouest'];

        // AJOUT du type "Libre" dans les types d'occupation
        $types_occupation = ['Autorisé', 'Anarchique', 'Libre'];

        $statuts = ['attribué', 'non attribué'];
        $motifs = ['Correction superficie', 'Mise à jour cadastrale', 'Litige résolu', 'Relevés GPS', 'Aucune modification'];
        $structures = [null, 'Ministère de l\'Éducation', 'École publique', 'Marché local', 'Centre de santé'];
        $litiges = [null, true, false];

        // ← Modifier ici: User -> Utilisateur
        $userIds = Utilisateur::pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $ancienne_superficie = rand(100, 2000) / 10;
            $nouvelle_superficie = rand(100, 2000) / 10;
            $litige = $litiges[array_rand($litiges)];

            // Détails spécifiques selon le type d'occupation
            $type_occupation = $types_occupation[array_rand($types_occupation)];

            if ($type_occupation === 'Autorisé') {
                $details_occupation = 'Occupation régulière conforme aux normes urbaines. Parcelle légalement enregistrée et conforme au plan d\'urbanisme.';
                $reference_autorisation = 'AUT-' . Str::random(8);
                $date_autorisation = now()->subDays(rand(30, 365));
                $date_expiration = rand(0, 1) ? $date_autorisation->copy()->addYears(rand(1, 5)) : null;
            } elseif ($type_occupation === 'Libre') {
                // Type "Libre" - parcelle sans occupation physique
                $details_occupation = 'Parcelle libre sans occupation physique actuelle. Terrain disponible.';
                $reference_autorisation = null;
                $date_autorisation = null;
                $date_expiration = null;
            } else {
                // Type "Anarchique"
                $details_occupation = 'Occupation irrégulière nécessitant régularisation. Situation nécessitant une intervention des services cadastraux.';
                $reference_autorisation = null;
                $date_autorisation = null;
                $date_expiration = null;
            }

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

                // CHAMPS D'OCCUPATION AVEC TYPE "LIBRE"
                'type_occupation' => $type_occupation,
                'details_occupation' => $details_occupation,
                'reference_autorisation' => $reference_autorisation,
                'date_autorisation' => $date_autorisation,
                'date_expiration_autorisation' => $date_expiration,

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
