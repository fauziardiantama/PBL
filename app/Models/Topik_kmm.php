<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topik_kmm extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topik_kmm';
    protected $primaryKey = 'id_topik';

    use HasFactory;
    protected $fillable = [
        'nama_topik'
    ];

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_topik', 'id_topik','id_dosen');
    }

    public function magang()
    {
        return $this->hasMany(Magang::class, 'id_topik');
    }
}
