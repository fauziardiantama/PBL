<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat_magang extends Model
{
    use HasFactory;
    protected $table = 'surat_magang';
    protected $primaryKey = 'id_surat';

    protected $fillable = [
        'id_magang',
        'no_urut',
        'jenis_surat',
        'nomor_surat',
        'file_surat',
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }
}
