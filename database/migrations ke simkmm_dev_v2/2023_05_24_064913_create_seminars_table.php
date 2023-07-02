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
        Schema::table('seminar', function (Blueprint $table) {
            $table->integer('id_magang')->nullable()->change();
            $table->date('tgl_seminar')->nullable()->change();
        });

        DB::table('seminar')
        ->where('tgl_seminar', '0000-00-00')
        ->update(['tgl_seminar' => null]); // or a valid date

        DB::table('seminar')->whereNotIn('id_magang', function ($query) {
            $query->select('id_magang')->from('magang');
        })->update(['id_magang' => null]);

        Schema::table('seminar', function (Blueprint $table) {
            $table->foreign('id_magang')->references('id_magang')->on('magang')->cascadeOnUpdate()->nullOnDelete();
            $table->string('lembar_revisi')->nullable()->change();
            $table->string('daftar_hadir')->nullable()->change();
            $table->string('selesai_kmm')->nullable()->change();
            $table->boolean('status')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar');
    }
};
