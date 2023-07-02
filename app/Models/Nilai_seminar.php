<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_seminar extends Model
{
    use HasFactory;
    protected $table = 'nilai_seminar';
    protected $primaryKey = 'id_nilai_seminar';

    protected $fillable = [
        'id_magang',
        'id_parameter',
        'nilai_pembimbing',
        'nilai_penguji',
        'nilai'
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter_nilai_seminar::class, 'id_parameter');
    }
}
