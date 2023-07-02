<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $progres_array = ['Pengajuan magang','Proses magang','Pengajuan seminar','Seminar magang','Selesai magang'];
        // $topik_array = ['Jaringan Komputer dan Automata','Sistem Informasi dan Sistem Manajemen Basis Data','Multimedia dan Mobile Programing','Multimedia dan Mobile Gaming'];
        $progres_daftar_array = ['pengajuan instansi menunggu diverifikasi admin', 'pengajuan magang menunggu diverifikasi dosen', 'pengajuan magang ke instansi belum diverifikasi admin', 'jawaban magang dari instansi belum diverifikasi admin', 'selesai pendaftaran'];

        //  \App\Models\Admin::factory()->create([
        //      'nama' => 'Agus Purbayu, S.Si., M.Kom.',
        //      'email' => 'admin@mail.com',
        //      'password' => bcrypt('password'),
        // ]);
        // for ($i=2018; $i <= 2023; $i++) { 
        //      \App\Models\Tahun::factory()->create([
        //          'tahun' => $i,
        //      ]);
        //  };
        // foreach ($progres_array as $progres) {
        //      \App\Models\Progres::factory()->create([
        //          'progres' => $progres,
        //      ]);
        //  };
        //  foreach ($topik_array as $topik) {
        //      \App\Models\Topik_kmm::factory()->create([
        //          'nama_topik' => $topik,
        //      ]);
        //  };
        //  \App\Models\Dosen::factory()->create([
        //      'nik' => '123456789',
        //      'nama' => 'Nama lengkap, S.Si., M.Kom.',
        //      'email' => 'dosencontoh@staff.uns.ac.id',
        //      'password' => bcrypt('password'),
        // ]);
        // \App\Models\Mahasiswa::factory()->create([
        //      'nim' => 'V123456',
        //      'nama' => 'Fauzi Ardiantama',
        //      'email' => 'fauziardiantami@student.uns.ac.id',
        //      'password' => bcrypt('password'),
        //      'no_telp' => '081234567890',
        //      'status' => 1,
        //  ]);
        foreach($progres_daftar_array as $progres_daftar) {
            \App\Models\Progres_daftar_magang::factory()->create([
                'status' => $progres_daftar
            ]);
        }   
    }
}
