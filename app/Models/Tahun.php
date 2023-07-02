<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;

    protected $table = 'tahun';
    protected $primaryKey = 'tahun';

    protected $fillable = [
        'tahun',
    ];

    public function bobot_nilai()
    {
        return $this->hasMany(Bobot_nilai::class, 'tahun');
    }

    public function magang()
    {
        return $this->hasMany(Magang::class, 'tahun');
    }

    public function parameter_nilai_bimbingan()
    {
        return $this->hasMany(Parameter_nilai_bimbingan::class, 'tahun');
    }

    public function parameter_nilai_instansi()
    {
        return $this->hasMany(Parameter_nilai_instansi::class, 'tahun');
    }

    public function parameter_nilai_seminar()
    {
        return $this->hasMany(Parameter_nilai_seminar::class, 'tahun');
    }
}
