<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter_nilai_instansi extends Model
{
    use HasFactory;
    protected $table = 'parameter_nilai_instansi';
    protected $primaryKey = 'id_parameter';

    protected $fillable = [
        'tahun',
        'parameter'
    ];

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun');
    }

    public function detail_nilai_instansi()
    {
        return $this->hasMany(Detail_nilai_instansi::class, 'id_parameter');
    }
}
