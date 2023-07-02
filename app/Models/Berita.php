<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'judul',
        'slug',
        'id_admin',
        'tanggal',
        'deskripsi',
        'status_publikasi',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    public function gambar()
    {
        return $this->hasMany(Gambar_berita::class, 'id_berita');
    }
}
