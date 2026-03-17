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
        Schema::create('commencers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscrit_id')->constrained('inscrits')->onDelete('cascade');
        $table->foreignId('tournoi_id')->constrained('tournois')->onDelete('cascade');
        $table->string('image');
        $table->string('status')->default('en attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commencers');
    }
};
