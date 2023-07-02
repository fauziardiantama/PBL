<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter_nilai_bimbingan extends Model
{
    use HasFactory;
    protected $table = 'parameter_nilai_bimbingan';
    protected $primaryKey = 'id_parameter';

    protected $fillable = [
        'tahun',
        'parameter'
    ];

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun');
    }

    public function nilai_bimbingan()
    {
        return $this->hasMany(Nilai_bimbingan::class, 'id_parameter');
    }
}
