<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';
    protected $fillable = [
        'nama_tahun_ajaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_aktif'
    ];

    public function jadwalPpdb()
    {
        return $this->hasMany(JadwalPpdb::class);
    }

    public function calonSiswa()
    {
        return $this->hasMany(CalonSiswa::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function kuotaPendaftaran()
    {
        return $this->hasMany(KuotaPendaftaran::class);
    }

    public function biayaPendaftaran()
    {
        return $this->hasMany(BiayaPendaftaran::class);
    }
}
