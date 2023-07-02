<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bobot_nilai extends Model
{
    use HasFactory;
    protected $table = 'bobot_nilai';
    protected $primaryKey = 'id_bobot';

    protected $fillable = [
        'tahun',
        'jenis_nilai',
        'persentase'
    ];

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun');
    }
}
