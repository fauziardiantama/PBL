<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen_registrasi extends Model
{
    use HasFactory;
    protected $table = 'dokumen_registrasi';
    protected $primaryKey = 'id_dokumen_registrasi';

    protected $fillable = [
        'nim',
        'krs',
        'transkrip',
        'bukti_seminar',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
