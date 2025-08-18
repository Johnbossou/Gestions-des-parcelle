<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('validations_log', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // Ex: 'parcelle_update'
            $table->foreignId('user_id')->constrained(); // Superviseur qui a fait l'action
            $table->foreignId('director_id')->constrained('utilisateurs'); // Directeur qui a validé
            $table->string('ip_address');
            $table->timestamps();

            // Optionnel : index pour améliorer les performances
            $table->index(['user_id', 'director_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('validations_log');
    }
};
