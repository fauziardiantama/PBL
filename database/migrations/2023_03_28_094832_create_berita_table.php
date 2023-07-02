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
        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->string('judul');
            $table->string('slug');
            $table->integer('id_admin')->nullable();
            $table->foreign('id_admin')->references('id_admin')->on('admin')->cascadeOnUpdate()->nullOnDelete();
            $table->date('tanggal');
            $table->mediumText('deskripsi');
            $table->boolean('status_publikasi')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
