<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progres_daftar_magang extends Model
{
    use HasFactory;
    protected $table = 'progres_daftar_magang';
    protected $primaryKey = 'id_status_daftar';

    protected $fillable = [
        'status',
    ];

    public function magang()
    {
        return $this->hasMany(Magang::class, 'id_status_daftar');
    }
}
