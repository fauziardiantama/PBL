<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat_jawaban extends Model
{
    use HasFactory;
    protected $table = 'surat_jawaban';
    protected $primaryKey = 'id_surat';

    protected $fillable = [
        'id_magang',
        'file_surat',
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }
}
