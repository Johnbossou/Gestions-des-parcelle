<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddFieldsToParcelles extends Migration
{
    public function up(): void
    {
        // Étape 1 : Mettre à jour les valeurs non valides dans type_terrain
        DB::table('parcelles')
            ->whereNotIn('type_terrain', ['Résidentiel', 'Commercial', 'Autre'])
            ->update(['type_terrain' => 'Autre']);

        // Étape 2 : Modifier la colonne type_terrain
        Schema::table('parcelles', function (Blueprint $table) {
            $table->enum('type_terrain', ['Résidentiel', 'Commercial', 'Agricole', 'Institutionnel', 'Autre'])
                  ->nullable()
                  ->default(null)
                  ->change();

            // Ajouter les nouveaux champs
            $table->boolean('litige')->nullable()->after('statut_attribution');
            $table->text('details_litige')->nullable()->after('litige');
            $table->string('structure')->nullable()->after('details_litige');
        });
    }

    public function down(): void
    {
        // Étape 1 : Mettre à jour les valeurs non valides avant de modifier l'enum
        DB::table('parcelles')
            ->whereIn('type_terrain', ['Agricole', 'Institutionnel'])
            ->update(['type_terrain' => 'Autre']);

        // Étape 2 : Revenir à l'ancien type_terrain
        Schema::table('parcelles', function (Blueprint $table) {
            $table->enum('type_terrain', ['Résidentiel', 'Commercial', 'Autre'])
                  ->nullable()
                  ->default(null)
                  ->change();

            // Supprimer les nouveaux champs
            $table->dropColumn(['litige', 'details_litige', 'structure']);
        });
    }
}
