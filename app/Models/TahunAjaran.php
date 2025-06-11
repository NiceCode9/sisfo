<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function jadwalPpdb(): HasMany
    {
        return $this->hasMany(JadwalPpdb::class);
    }

    public function calonSiswa(): HasMany
    {
        return $this->hasMany(CalonSiswa::class);
    }

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    public function kuotaPendaftaran(): HAsMany
    {
        return $this->hasMany(KuotaPendaftaran::class);
    }

    public function biayaPendaftaran(): HasMany
    {
        return $this->hasMany(BiayaPendaftaran::class);
    }

    // Relasi dengan RiwayatKelas
    public function riwayatKelas(): HasMany
    {
        return $this->hasMany(RiwayatKelas::class);
    }

    // Relasi dengan GuruKelas
    public function guruKelas(): HasMany
    {
        return $this->hasMany(GuruKelas::class);
    }

    // Relasi dengan Jadwal
    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }
}
