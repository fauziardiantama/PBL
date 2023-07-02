<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PasswordSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('admin')->update(['password' => bcrypt('password')]);
        DB::table('dosen')->update(['password' => bcrypt('password')]);
        DB::table('mahasiswa')->update(['password' => bcrypt('password')]);
    }
}
