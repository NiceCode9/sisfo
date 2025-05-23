<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    use HasFactory;

    protected $table = 'calon_siswa';
    protected $fillable = [
        'jalur_pendaftaran_id',
        'no_pendaftaran',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'asal_sekolah',
        'nama_orang_tua',
        'pekerjaan_orang_tua',
        'no_hp_orang_tua',
        'tahun_ajaran_id',
        'jalur_pendaftaran_id',
        'status_pendaftaran'
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function jalurPendaftaran()
    {
        return $this->belongsTo(JalurPendaftaran::class);
    }

    public function berkasCalonSiswa()
    {
        return $this->hasOne(BerkasCalonSiswa::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function logStatusPendaftaran()
    {
        return $this->hasMany(LogStatusPendaftaran::class);
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }
}
