<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gambar_berita extends Model
{
    use HasFactory;

    protected $table = 'gambar_berita';
    protected $primaryKey = 'id_gambar';

    protected $fillable = [
        'id_berita',
        'gambar'
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'id_berita');
    }
}
