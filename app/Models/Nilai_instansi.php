<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_instansi extends Model
{
    use HasFactory;
    protected $table = 'nilai_instansi';
    protected $primaryKey = 'id_nilai_instansi';

    protected $fillable = [
        'id_magang',
        'dokumen',
        'status'
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }

    public function detail_nilai_instansi()
    {
        return $this->hasMany(Detail_nilai_instansi::class, 'id_nilai_instansi');
    }
}
