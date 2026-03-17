<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phase_finale_matchs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournoi_id')->constrained()->onDelete('cascade');

            $table->enum('round', ['quarter', 'semi', 'final']);

            $table->foreignId('player1_id')->nullable()->constrained('inscrits')->nullOnDelete();
            $table->foreignId('player2_id')->nullable()->constrained('inscrits')->nullOnDelete();

            // Scores aller
            $table->integer('score1_aller')->nullable();
            $table->integer('score2_aller')->nullable();

            // Scores retour
            $table->integer('score1_retour')->nullable();
            $table->integer('score2_retour')->nullable();

            // Scores totaux
            $table->integer('score_total1')->nullable();
            $table->integer('score_total2')->nullable();

            $table->foreignId('winner_id')->nullable()->constrained('inscrits')->nullOnDelete();

            $table->integer('order')->default(0); // ordre du match dans le round

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phase_finale_matchs');
    }
};
