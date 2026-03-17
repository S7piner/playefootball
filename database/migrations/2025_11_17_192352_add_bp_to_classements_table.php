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
        Schema::table('classements', function (Blueprint $table) {
             $table->integer('bp')->default(0)->after('p');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classements', function (Blueprint $table) {
            $table->dropColumn('bp');
        });
    }
};
