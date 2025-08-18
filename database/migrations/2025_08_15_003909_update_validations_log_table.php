<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Dans votre fichier 2025_08_15_003909_update_validations_log_table.php
public function up()
{
    Schema::table('validations_log', function (Blueprint $table) {
        // Supprimer les anciennes contraintes si elles existent
        $table->dropForeign(['user_id']);
        $table->dropForeign(['director_id']);

        // Recréer les contraintes avec les bonnes références
        $table->foreign('user_id')
              ->references('id')
              ->on('utilisateurs')
              ->onDelete('cascade');

        $table->foreign('director_id')
              ->references('id')
              ->on('utilisateurs')
              ->onDelete('cascade');

        // Ajouter les nouveaux index
        $table->index('user_id');
        $table->index('director_id');
        $table->index(['action', 'created_at']);

        // Modifier la colonne ip_address si nécessaire
        $table->string('ip_address', 45)->change();
    });
}

public function down()
{
    Schema::table('validations_log', function (Blueprint $table) {
        // Annuler les modifications si besoin
        $table->dropForeign(['user_id']);
        $table->dropForeign(['director_id']);
        $table->dropIndex(['user_id']);
        $table->dropIndex(['director_id']);
        $table->dropIndex(['action', 'created_at']);
    });
}
};
