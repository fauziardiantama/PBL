<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE magang MODIFY tahun YEAR(4) NULL');

        Schema::table('magang', function (Blueprint $table) {
            $table->string('NIM')->nullable()->change();
            $table->integer('id_topik')->nullable()->change();
            $table->integer('id_instansi')->nullable()->change();
            $table->boolean('status_pengajuan_instansi')->nullable()->default(null)->change();
            $table->boolean('status_diterima_instansi')->nullable()->default(null)->change();
            $table->integer('id_dosen')->nullable()->change();
            $table->boolean('status_dosen')->nullable()->change();
            $table->integer('id_progres')->nullable()->change();
            $table->unsignedBigInteger('id_status_daftar')->nullable();
        });

        //change every foreign key to null if the referenced row is deleted
        DB::table('magang')->whereNotIn('NIM', function ($query) {
            $query->select('nim')->from('mahasiswa');
        })->update(['NIM' => null]);

        DB::table('magang')->whereNotIn('tahun', function ($query) {
            $query->select('tahun')->from('tahun');
        })->update(['tahun' => null]);

        DB::table('magang')->whereNotIn('id_topik', function ($query) {
            $query->select('id_topik')->from('topik_kmm');
        })->update(['id_topik' => null]);

        DB::table('magang')->whereNotIn('id_instansi', function ($query) {
            $query->select('id_instansi')->from('instansi');
        })->update(['id_instansi' => null]);

        DB::table('magang')->whereNotIn('id_dosen', function ($query) {
            $query->select('id_dosen')->from('dosen');
        })->update(['id_dosen' => null]);

        DB::table('magang')->whereNotIn('id_progres', function ($query) {
            $query->select('id_progres')->from('progres');
        })->update(['id_progres' => null]);

        DB::table('magang')->whereNotIn('id_status_daftar', function ($query) {
            $query->select('id_status_daftar')->from('progres_daftar_magang');
        })->update(['id_status_daftar' => null]);

        Schema::table('magang', function (Blueprint $table) {
            $table->foreign('NIM')->references('nim')->on('mahasiswa')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('tahun')->references('tahun')->on('tahun')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('id_topik')->references('id_topik')->on('topik_kmm')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('id_instansi')->references('id_instansi')->on('instansi')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('id_dosen')->references('id_dosen')->on('dosen')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('id_progres')->references('id_progres')->on('progres')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('id_status_daftar')->references('id_status_daftar')->on('progres_daftar_magang')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magang');
    }
};
