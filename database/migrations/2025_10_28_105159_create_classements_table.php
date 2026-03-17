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
        Schema::create('classements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournoi_id')->constrained()->onDelete('cascade');
            $table->foreignId('inscrit_id')->constrained()->onDelete('cascade');
            $table->integer('mj')->default(0); // Matchs Joués
            $table->integer('g')->default(0);  // Victoires
            $table->integer('n')->default(0);  // Matchs Nuls
            $table->integer('p')->default(0);  // Défaites
            $table->integer('bc')->default(0); // Buts Contre
            $table->integer('points')->default(0);
            $table->timestamps();

            $table->unique(['tournoi_id', 'inscrit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classements');
    }
};
