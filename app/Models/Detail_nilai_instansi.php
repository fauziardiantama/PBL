<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_nilai_instansi extends Model
{
    use HasFactory;
    protected $table = 'detail_nilai_instansi';
    protected $primaryKey = 'id_detail_nilai';

    protected $fillable = [
        'id_nilai_instansi',
        'id_parameter',
        'nilai'
    ];

    public function nilai_instansi()
    {
        return $this->belongsTo(Nilai_instansi::class, 'id_nilai_instansi');
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter_nilai_instansi::class, 'id_parameter');
    }
}
