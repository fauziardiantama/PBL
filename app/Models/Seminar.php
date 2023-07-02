<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;
    protected $table = 'seminar';
    protected $primaryKey = 'id_seminar';

    protected $fillable = [
        'id_magang',
        'tgl_daftar',
        'tgl_seminar',
        'judul_kmm',
        'draft_kmm',
        'foto',
        'krs',
        'lembar_revisi',
        'daftar_hadir',
        'selesai_kmm',
        'status'
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }

    
}
