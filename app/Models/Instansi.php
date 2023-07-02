<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansi';
    protected $primaryKey = 'id_instansi';

    protected $fillable = [
        'nama',
        'email',
        'status_email',
        'alamat',
        'no_telp',
        'web',
        'status_instansi'
    ];

    public function magang()
    {
        return $this->hasMany(Magang::class, 'id_instansi');
    }
    
}
