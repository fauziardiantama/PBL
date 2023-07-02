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
        Schema::table('dosen_topik', function (Blueprint $table) {
            $table->dropForeign('dosen_topik_ibfk_1');
            $table->dropForeign('dosen_topik_ibfk_2');
        });

        Schema::table('dosen_topik', function (Blueprint $table) {
            $table->integer('id_dosen')->nullable()->change();
            $table->integer('id_topik')->nullable()->change();
        });

        DB::table('dosen_topik')
        ->whereNotIn('id_dosen', function ($query) {
            $query->select('id_dosen')->from('dosen');
        })->update(['id_dosen' => null]);

        DB::table('dosen_topik')
        ->whereNotIn('id_topik', function ($query) {
            $query->select('id_topik')->from('topik_kmm');
        })->update(['id_topik' => null]);

        Schema::table('dosen_topik', function (Blueprint $table) {
            $table->foreign('id_dosen')->references('id_dosen')->on('dosen')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_topik')->references('id_topik')->on('topik_kmm')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_topik');
    }
};
