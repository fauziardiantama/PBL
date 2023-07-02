<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_bimbingan extends Model
{
    use HasFactory;
    protected $table = 'nilai_bimbingan';
    protected $primaryKey = 'id_nilai_bimbingan';

    protected $fillable = [
        'id_magang',
        'id_parameter',
        'nilai'
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter_nilai_bimbingan::class, 'id_parameter');
    }
}
