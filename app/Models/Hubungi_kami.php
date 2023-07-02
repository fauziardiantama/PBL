<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hubungi_kami extends Model
{
    use HasFactory;

    protected $table = 'Hubungi_kami';
    protected $fillable =[
        'nama',
        'email',
        'subjek',
        'pesan',
    ];
}
