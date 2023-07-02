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
        Schema::table('nilai_seminar', function (Blueprint $table) {
            $table->integer('nilai_pembimbing')->nullable();
            $table->integer('nilai_penguji')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_seminar', function (Blueprint $table) {
            //
        });
    }
};
