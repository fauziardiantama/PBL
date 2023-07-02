<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;
    protected $table = 'magang';
    protected $primaryKey = 'id_magang';

    protected $fillable = [
        'nim',
        'tahun',
        'id_topik',
        'id_instansi',
        'status_pengajuan_instansi',
        'status_diterima_instansi',
        'id_dosen',
        'status_dosen',
        'id_progres',
        'id_status_daftar'
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi');
    }

    public function topik()
    {
        return $this->belongsTo(Topik_kmm::class, 'id_topik');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }

    public function progres()
    {
        return $this->belongsTo(Progres::class, 'id_progres');
    }

    public function rencana_magang()
    {
        return $this->hasMany(Rencana_magang::class, 'id_magang');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun');
    }

    public function nilai_akhir()
    {
        return $this->hasOne(Nilai_akhir::class, 'id_magang');
    }

    public function nilai_bimbingan()
    {
        return $this->hasMany(Nilai_bimbingan::class, 'id_magang');
    }

    public function nilai_instansi()
    {
        return $this->hasOne(Nilai_instansi::class, 'id_magang');
    }

    public function nilai_seminar()
    {
        return $this->hasMany(Nilai_seminar::class, 'id_magang');
    }

    public function revisi()
    {
        return $this->hasOne(Revisi::class, 'id_magang');
    }

    public function bimbingan_dosen()
    {
        return $this->hasMany(Bimbingan_dosen::class, 'id_magang');
    }

    public function bimbingan_instansi()
    {
        return $this->hasMany(Bimbingan_instansi::class, 'id_magang');
    }

    public function surat_jawaban()
    {
        return $this->hasOne(Surat_jawaban::class, 'id_magang');
    }

    public function surat_magang()
    {
        return $this->hasMany(Surat_magang::class, 'id_magang');
    }

    public function progres_daftar_magang()
    {
        return $this->belongsTo(Progres_daftar_magang::class, 'id_status_daftar');
    }

    public function seminar()
    {
        return $this->hasOne(Seminar::class, 'id_magang');
    }

    public function dosen_penguji()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }
}
