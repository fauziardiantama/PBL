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
        Schema::table('revisi', function (Blueprint $table) {
            $table->integer('id_magang')->nullable()->change();
        });

        DB::table('revisi')->whereNotIn('id_magang', function ($query) {
            $query->select('id_magang')->from('magang');
        })->update(['id_magang' => null]);

        Schema::table('revisi', function (Blueprint $table) {
            $table->foreign('id_magang')->references('id_magang')->on('magang')->cascadeOnUpdate()->nullOnDelete();
            $table->string('daftar_hadir')->nullable()->change();
            $table->boolean('status')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisi');
    }
};
