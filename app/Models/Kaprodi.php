<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaprodi extends Model
{
    use HasFactory;
    protected $table = 'kaprodi';
    protected $primaryKey = 'id_kaprodi';

    protected $fillable = [
        'nik',
        'nama',
    ];
}
