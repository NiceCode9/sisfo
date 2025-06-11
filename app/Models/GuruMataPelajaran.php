<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuruMataPelajaran extends Model
{
    protected $table = 'guru_mata_pelajaran';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'keterangan',
    ];

    /**
     * Get the guru that owns the GuruMataPelajaran.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function guruKelas()
    {
        return $this->hasMany(GuruKelas::class, 'guru_mata_pelajaran_id');
    }

    /**
     * Get the mata pelajaran that owns the GuruMataPelajaran.
     */
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    // public function jadwal()
    // {
    //     return $this->hasMany(Jadwal::class, 'guru_mata_pelajaran_id');
    // }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'guru_kelas_id', 'id')
            ->through('guru_kelas');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'guru_mata_pelajaran_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'guru_mata_pelajaran_id');
    }

    // public function diskusi()
    // {
    //     return $this->hasMany(Diskusi::class, 'id_guru_mata_pelajaran');
    // }
}
