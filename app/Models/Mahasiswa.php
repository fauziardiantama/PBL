<?php


namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mahasiswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nim',
        'nama',
        'email',
        'password',
        'no_telp',
        'status'
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

    public function kondisi(): HasOne
    {
        return $this->hasOne(Kondisi_mahasiswa::class, 'nomor_induk_mahasiswa', 'nim');
    }

    public function dokumen(): HasOne
    {
        return $this->hasOne(Dokumen_registrasi::class, 'nim');
    }

    public function magang(): HasOne
    {
        return $this->hasOne(Magang::class, 'nim');
    }

    public function isAdmin()
    {
        return false;
    }
    public function isDosen()
    {
        return false;
    }
    public function isMahasiswa()
    {
        return true;
    }
}
