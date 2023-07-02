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
        Schema::table('dokumen_registrasi', function (Blueprint $table) {
            $table->string('nim')->nullable()->change();
        });

        DB::table('dokumen_registrasi')->whereNotIn('nim', function ($query) {
            $query->select('nim')->from('mahasiswa');
        })->update(['nim' => null]);

        Schema::table('dokumen_registrasi', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_registrasi');
    }
};
