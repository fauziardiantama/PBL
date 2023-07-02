<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan_dosen extends Model
{
    use HasFactory;

    protected $table = 'bimbingan_dosen';
    protected $primaryKey = 'id_bimbingan_dosen';

    protected $fillable = [
        'id_magang',
        'tanggal',
        'data_bimbingan',
        'status'
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }
}
