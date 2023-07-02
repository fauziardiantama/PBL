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
            $table->integer('id_magang')->nullable()->change();
            $table->integer('id_parameter')->nullable()->change();
        });

        DB::table('nilai_seminar')->whereNotIn('id_magang', function ($query) {
            $query->select('id_magang')->from('magang');
        })->update(['id_magang' => null]);

        DB::table('nilai_seminar')->whereNotIn('id_parameter', function ($query) {
            $query->select('id_parameter')->from('parameter_nilai_seminar');
        })->update(['id_parameter' => null]);

        Schema::table('nilai_seminar', function (Blueprint $table) {
            $table->foreign('id_magang')->references('id_magang')->on('magang')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('id_parameter')->references('id_parameter')->on('parameter_nilai_seminar')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_seminar');
    }
};
