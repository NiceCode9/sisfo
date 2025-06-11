<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'jurusan',
        'deskripsi',
    ];

    /**
     * Get the siswa associated with the kelas.
     */
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    public function riwayatKelas(): HasMany
    {
        return $this->hasMany(RiwayatKelas::class);
    }

    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'riwayat_kelas')
            ->withPivot(['tahun_ajaran_id', 'status', 'keterangan'])
            ->withTimestamps();
    }

    public function guruKelas(): HasMany
    {
        return $this->hasMany(GuruKelas::class);
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'guru_kelas_id', 'id')
            ->through('guru_kelas');
    }

    public function siswaAktif($tahunAjaranId = null)
    {
        $query = $this->siswa()->wherePivot('status', 'aktif');

        if ($tahunAjaranId) {
            $query->wherePivot('tahun_ajaran_id', $tahunAjaranId);
        }

        return $query;
    }

    public function guruPengajar($tahunAjaranId = null)
    {
        $query = $this->guruKelas()->where('aktif', true);

        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }

        return $query->with(['guruMataPelajaran.guru', 'guruMataPelajaran.mataPelajaran']);
    }
}
