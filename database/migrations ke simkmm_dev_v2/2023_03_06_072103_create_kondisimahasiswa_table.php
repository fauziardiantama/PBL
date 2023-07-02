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
        Schema::table('kondisimahasiswa', function (Blueprint $table) {
            $table->date('tanggal_submit')->nullable()->default(null)->change();
            $table->string('nomor_induk_mahasiswa')->nullable()->change();
        });

        // Run this code in your migration or a separate script
        DB::table('kondisimahasiswa')
        ->where('tanggal_submit', '0000-00-00')
        ->update(['tanggal_submit' => null]); // or a valid date

        DB::table('kondisimahasiswa')
        ->whereNotIn('nomor_induk_mahasiswa', function ($query) {
            $query->select('nim')->from('mahasiswa');
        })->update(['nomor_induk_mahasiswa' => null]);

        Schema::table('kondisimahasiswa', function (Blueprint $table) {
            $table->foreign('nomor_induk_mahasiswa')->references('nim')->on('mahasiswa')->cascadeOnUpdate()->nullOnDelete()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kondisimahasiswa');
    }
};
