<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gestionnaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('prenoms');
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->enum('statut', ['actif', 'inactif', 'suspendu', 'en_conge'])->default('actif');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['statut']);
        });

        // Table pivot pour la relation many-to-many entre gestionnaires et entreprises
        Schema::create('gestionnaire_entreprise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gestionnaire_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Index pour éviter les doublons
            $table->unique(['gestionnaire_id', 'client_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestionnaire_entreprise');
        Schema::dropIfExists('gestionnaires');
    }
};
