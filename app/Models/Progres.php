<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progres extends Model
{
    use HasFactory;
    protected $table = 'progres';
    protected $primaryKey = 'id_progres';
    protected $fillable =[
        'id_progres',
        'progres'
    ];

    public function magang()
    {
        return $this->hasMany(Magang::class, 'id_progres');
    }
}
