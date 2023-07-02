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
        
        DB::statement('ALTER TABLE bobot_nilai MODIFY tahun YEAR(4) NULL');

        DB::table('bobot_nilai')->whereNotIn('tahun', function ($query) {
            $query->select('tahun')->from('tahun');
        })->update(['tahun' => null]);

        Schema::table('bobot_nilai', function (Blueprint $table) {
            $table->foreign('tahun')->references('tahun')->on('tahun')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobot_nilai');
    }
};
