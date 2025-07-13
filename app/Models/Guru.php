<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'biografi',
        'bidang_keahlian',
        'alamat',
        'gelar',
        'telp',
        'foto_path',
    ];

    /**
     * Get the user that owns the guru.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mata_pelajaran', 'guru_id', 'mata_pelajaran_id')
            ->withTimestamps();
    }

    // public function guruMataPelajaran()
    // {
    //     return $this->hasMany(GuruMataPelajaran::class, 'guru_id');
    // }

    // public function guruKelas(): HasMany
    // {
    //     return $this->hasMany(GuruKelas::class, 'guru_mata_pelajaran_id', 'id')
    //         ->through('guru_mata_pelajaran');
    // }

    // public function kelasYangDiajar($tahunAjaranId = null)
    // {
    //     $query = $this->hasManyThrough(Kelas::class, GuruKelas::class, 'guru_mata_pelajaran_id', 'id', 'id', 'kelas_id')
    //         ->through(GuruMataPelajaran::class);

    //     if ($tahunAjaranId) {
    //         $query->where('guru_kelas.tahun_ajaran_id', $tahunAjaranId);
    //     }

    //     return $query->where('guru_kelas.aktif', true);
    // }

    public function guruMataPelajaran()
    {
        return $this->hasMany(GuruMataPelajaran::class);
    }

    public function guruKelas()
    {
        return $this->hasManyThrough(
            GuruKelas::class,
            GuruMataPelajaran::class,
            'guru_id', // FK di guru_mata_pelajaran
            'guru_mata_pelajaran_id', // FK di guru_kelas
            'id', // PK di guru
            'id' // PK di guru_mata_pelajaran
        );
    }

    public function kelasYangDiajar($tahunAjaranId = null)
    {
        $query = Kelas::whereHas('guruKelas', function ($q) {
            $q->whereHas('guruMataPelajaran', function ($q) {
                $q->where('guru_id', $this->id);
            })
                ->where('aktif', true);
        });

        if ($tahunAjaranId) {
            $query->whereHas('guruKelas', function ($q) use ($tahunAjaranId) {
                $q->where('tahun_ajaran_id', $tahunAjaranId);
            });
        }

        return $query;
    }
}
