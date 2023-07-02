<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    use HasFactory;
    protected $table = 'revisi';
    protected $primaryKey = 'id_revisi';

    protected $fillable = [
        'id_magang',
        'tgl_upload',
        'laporan_revisi',
        'selesai_kmm',
        'daftar_hadir',
        'status'
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }
}
