<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcelles', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->integer('numero')->nullable(); // Ordre d'entrée dans Excel
            $table->string('arrondissement');
            $table->string('secteur');
            $table->integer('lot');
            $table->string('designation')->nullable();
            $table->string('parcelle')->unique();
            $table->decimal('ancienne_superficie', 10, 2)->nullable();
            $table->decimal('nouvelle_superficie', 10, 2)->nullable();
            $table->decimal('ecart_superficie', 10, 2)->nullable();
            $table->string('motif')->nullable();
            $table->text('observations')->nullable();
            $table->enum('type_terrain', ['Résidentiel', 'Commercial', 'Autre'])->nullable();
            $table->enum('statut_attribution', ['attribué', 'non attribué'])->nullable();
            $table->date('date_mise_a_jour')->nullable();
            $table->decimal('latitude', 9, 6)->nullable(); // Coordonnées
            $table->decimal('longitude', 9, 6)->nullable(); // Coordonnées
            $table->foreignId('agent')->nullable()->constrained('utilisateurs')->onDelete('set null');
            $table->foreignId('responsable_id')->nullable()->constrained('utilisateurs')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('utilisateurs')->onDelete('set null');
            $table->timestamps();

            // Index avec un nom court pour éviter l'erreur de longueur
            $table->index(
                ['numero', 'parcelle', 'arrondissement', 'lot', 'type_terrain', 'statut_attribution', 'latitude', 'longitude'],
                'parcelles_main_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcelles');
    }
};
