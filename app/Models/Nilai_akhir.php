<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_akhir extends Model
{
    use HasFactory;
    protected $table = 'nilai_akhir';
    protected $primaryKey = 'id_nilai_akhir';

    protected $fillable = [
        'id_magang',
        'nilai_akhir',
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }
}
