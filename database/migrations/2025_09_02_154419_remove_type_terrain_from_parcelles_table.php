<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Supprimer la colonne type_terrain
        Schema::table('parcelles', function (Blueprint $table) {
            $table->dropColumn('type_terrain');
        });

        // 2. Ajouter les nouvelles colonnes pour l'occupation
        Schema::table('parcelles', function (Blueprint $table) {
            $table->enum('type_occupation', ['Autorisé', 'Anarchique', 'Libre']) // ← Ajouter 'Libre'
                  ->nullable()
                  ->after('observations')
                  ->comment('Type d\'occupation de la parcelle');

            $table->text('details_occupation')
                  ->nullable()
                  ->after('type_occupation')
                  ->comment('Détails spécifiques selon le type d\'occupation');

            $table->string('reference_autorisation', 100)
                  ->nullable()
                  ->after('details_occupation')
                  ->comment('Référence officielle de l\'autorisation');

            $table->date('date_autorisation')
                  ->nullable()
                  ->after('reference_autorisation')
                  ->comment('Date d\'obtention de l\'autorisation');

            $table->date('date_expiration_autorisation')
                  ->nullable()
                  ->after('date_autorisation')
                  ->comment('Date d\'expiration de l\'autorisation');
        });

        // 3. Mettre à jour l'index composite
        Schema::table('parcelles', function (Blueprint $table) {
            $table->dropIndex('parcelles_main_index');

            $table->index(
                [
                    'numero',
                    'parcelle',
                    'arrondissement',
                    'lot',
                    'type_occupation',  // ← Remplacé ici
                    'statut_attribution',
                    'latitude',
                    'longitude'
                ],
                'parcelles_main_index'
            );
        });
    }

    public function down(): void
    {
        // 1. Supprimer les nouvelles colonnes
        Schema::table('parcelles', function (Blueprint $table) {
            $table->dropColumn([
                'type_occupation',
                'details_occupation',
                'reference_autorisation',
                'date_autorisation',
                'date_expiration_autorisation'
            ]);
        });

        // 2. Recréer l'ancienne colonne type_terrain
        Schema::table('parcelles', function (Blueprint $table) {
            $table->enum('type_terrain', ['Résidentiel', 'Commercial', 'Agricole', 'Institutionnel', 'Autre'])
                  ->nullable()
                  ->after('observations');
        });

        // 3. Rétablir l'ancien index
        Schema::table('parcelles', function (Blueprint $table) {
            $table->dropIndex('parcelles_main_index');

            $table->index(
                [
                    'numero',
                    'parcelle',
                    'arrondissement',
                    'lot',
                    'type_terrain',  // ← Ancien index
                    'statut_attribution',
                    'latitude',
                    'longitude'
                ],
                'parcelles_main_index'
            );
        });
    }
};
