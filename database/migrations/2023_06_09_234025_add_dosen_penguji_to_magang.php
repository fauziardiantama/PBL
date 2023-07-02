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
        Schema::table('magang', function (Blueprint $table) {
            $table->integer('id_dosen_penguji')->nullable();
            $table->foreign('id_dosen_penguji')->references('id_dosen')->on('dosen')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magang', function (Blueprint $table) {
            //
        });
    }
};
