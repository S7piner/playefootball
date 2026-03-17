<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('inscrits', function (Blueprint $table) {
            $table->foreignId('tournoi_id')
                  ->nullable() // ← GARDER nullable car pas de tournoi à l'inscription
                  ->constrained('tournois')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('inscrits', function (Blueprint $table) {
            $table->dropForeign(['tournoi_id']);
            $table->dropColumn('tournoi_id');
        });
    }
};
