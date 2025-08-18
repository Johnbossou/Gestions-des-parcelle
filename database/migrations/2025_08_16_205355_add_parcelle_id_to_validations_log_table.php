<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB; // <-- Ajoutez cette ligne
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('validations_log', function (Blueprint $table) {
        // 1. Ajouter la colonne nullable
        $table->unsignedBigInteger('parcelle_id')->nullable()->after('id');
    });

    // 2. Mettre à jour les logs existants avec des valeurs valides
    $parcelles = DB::table('parcelles')->pluck('id');
    if ($parcelles->isNotEmpty()) {
        $defaultParcelleId = $parcelles->first();
        DB::table('validations_log')->update(['parcelle_id' => $defaultParcelleId]);
    }

    // 3. Ajouter la contrainte
    Schema::table('validations_log', function (Blueprint $table) {
        $table->unsignedBigInteger('parcelle_id')->nullable(false)->change();
        $table->foreign('parcelle_id')
              ->references('id')
              ->on('parcelles')
              ->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::table('validations_log', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['parcelle_id']);

            // Supprimer la colonne
            $table->dropColumn('parcelle_id');

            // Supprimer l'index
            $table->dropIndex(['parcelle_id']);
        });
    }
};
