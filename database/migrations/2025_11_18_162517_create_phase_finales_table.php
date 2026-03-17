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
        Schema::create('phase_finales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournoi_id')->constrained()->onDelete('cascade');

            $table->enum('round', ['quarter', 'semi', 'final']);

            $table->foreignId('player1_id')->nullable()->constrained('inscrits')->nullOnDelete();
            $table->foreignId('player2_id')->nullable()->constrained('inscrits')->nullOnDelete();

            $table->integer('score1')->nullable();
            $table->integer('score2')->nullable();

            $table->foreignId('winner_id')->nullable()->constrained('inscrits')->nullOnDelete();

            $table->integer('order')->default(0); // ordre du match dans le round

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phase_finales');
    }
};
