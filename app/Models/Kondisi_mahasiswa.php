<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kondisi_mahasiswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kondisimahasiswa';
    protected $primaryKey = 'id_kondisi';

    protected $fillable = [
        'nomor_induk_mahasiswa',
        'nama_lengkap',
        'fakultas',
        'program_prodi',
        'nomor_telepon',
        'email_SSO',
        'alamat_asal_jalan_dan_nomor_rumah',
        'alamat_asal_RT_RW',
        'alamat_asal_kelurahan',
        'alamat_asal_kabupaten_kota',
        'alamat_asal_provinsi',
        'alamat_di_solo',
        'alamat_solo_jalan_dan_nomor_rumah',
        'alamat_solo_RT_RW',
        'alamat_solo_kelurahan',
        'alamat_solo_kecamatan',
        'alamat_solo_kabupaten_kota',
        'alamat_solo_provinsi',
        'alamat_saat_isi',
        'alamat_saat_isi_jalan_dan_nomor_rumah',
        'alamat_saat_isi_RT_RW',
        'alamat_saat_isi_kelurahan',
        'alamat_saat_isi_kecamatan',
        'alamat_saat_isi_kabupaten_kota',
        'alamat_saat_isi_provinsi',
        'tanggal_mulai_tinggal_alamat_sekarang',
        'moda_dipakai_meninggalkan_solo_ke_alamat_sekarang',
        'keadaan_sekarang',
        'sakit_keterangan',
        'sakit_status_periksa',
        'sakit_periksa_diagnosa_saran_dokter',
        'tanggal_submit'
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nomor_induk_mahasiswa');
    }
}
