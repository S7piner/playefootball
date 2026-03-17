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
        Schema::create('journers', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_journee');
            $table->foreignId('tournoi_id')->constrained()->onDelete('cascade');
            $table->foreignId('joueur1_id')->constrained('inscrits')->onDelete('cascade');
            $table->foreignId('joueur2_id')->constrained('inscrits')->onDelete('cascade');
            $table->integer('score_joueur1')->nullable();
            $table->integer('score_joueur2')->nullable();
            $table->string('statut')->default('programme'); // programme, en_cours, termine
            $table->dateTime('date_match')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journers');
    }
};
