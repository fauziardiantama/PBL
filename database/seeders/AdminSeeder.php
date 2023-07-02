<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //\App\Models\Admin::factory(1)->create();
        \App\Models\Admin::factory()->create([
             'nama' => 'Agus Purbayu, S.Si., M.Kom.',
             'email' => 'admin@mail.com',
             'password' => bcrypt('password'),
        ]);
    }
}
