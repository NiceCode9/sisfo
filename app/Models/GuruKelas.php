<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuruKelas extends Model
{
    use HasFactory;

    protected $table = 'guru_kelas';

    protected $fillable = [
        'guru_mata_pelajaran_id',
        'kelas_id',
        'tahun_ajaran_id',
        'aktif',
        'keterangan'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];

    // Relasi dengan GuruMataPelajaran
    public function guruMataPelajaran(): BelongsTo
    {
        return $this->belongsTo(GuruMataPelajaran::class, 'guru_mata_pelajaran_id');
    }

    // Relasi dengan Kelas
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi dengan TahunAjaran
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    // Relasi dengan Jadwal
    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    // Relasi dengan Materi
    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class);
    }

    // Relasi dengan Tugas
    public function tugas(): HasMany
    {
        return $this->hasMany(Tugas::class);
    }

    // Accessor untuk mendapatkan info guru
    public function getGuruAttribute()
    {
        return $this->guruMataPelajaran->guru ?? null;
    }

    // Accessor untuk mendapatkan info mata pelajaran
    public function getMataPelajaranAttribute()
    {
        return $this->guruMataPelajaran->mataPelajaran ?? null;
    }
}
