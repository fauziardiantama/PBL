<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter_nilai_seminar extends Model
{
    use HasFactory;
    protected $table = 'parameter_nilai_seminar';
    protected $primaryKey = 'id_parameter';

    protected $fillable = [
        'tahun',
        'parameter'
    ];

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun');
    }

    public function nilai_seminar()
    {
        return $this->hasMany(Nilai_seminar::class, 'id_parameter');
    }
}
