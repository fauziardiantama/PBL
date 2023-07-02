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
        Schema::table('detail_nilai_instansi', function (Blueprint $table) {
            $table->integer('id_nilai_instansi')->nullable()->change();
            $table->integer('id_parameter')->nullable()->change();
        });

        DB::table('detail_nilai_instansi')->whereNotIn('id_nilai_instansi', function ($query) {
            $query->select('id_nilai_instansi')->from('nilai_instansi');
        })->update(['id_nilai_instansi' => null]);

        DB::table('detail_nilai_instansi')->whereNotIn('id_parameter', function ($query) {
            $query->select('id_parameter')->from('parameter_nilai_seminar');
        })->update(['id_parameter' => null]);

        Schema::table('detail_nilai_instansi', function (Blueprint $table) {
            $table->foreign('id_nilai_instansi')->references('id_nilai_instansi')->on('nilai_instansi')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('id_parameter')->references('id_parameter')->on('parameter_nilai_seminar')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_nilai_instansi');
    }
};
