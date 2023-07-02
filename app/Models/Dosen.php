<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dosen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'nama',
        'email',
        'password',
        'id_topik',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return false;
    }
    public function isDosen()
    {
        return true;
    }
    public function isMahasiswa()
    {
        return false;
    }

    public function topik()
    {
        return $this->belongsToMany(Topik_kmm::class, 'dosen_topik', 'id_dosen', 'id_topik');
    }

    public function magang()
    {
        return $this->hasMany(Magang::class, 'id_dosen');
    }

    public function magang_penguji()
    {
        return $this->hasMany(Magang::class, 'id_dosen_penguji');
    }
}
