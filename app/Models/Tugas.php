<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'guru_kelas_id',
        'judul',
        'deskripsi',
        'batas_waktu',
        'total_nilai',
        'jenis',
        'metode_pengerjaan',
        'file_tugas',
        'visibilitas',
        'tanggal_terbit',
        'aktif'
    ];

    protected $casts = [
        'batas_waktu' => 'datetime',
        'total_nilai' => 'integer',
        'jenis' => 'string',
        'metode_pengerjaan' => 'string',
        'visibilitas' => 'string',
        'tanggal_terbit' => 'datetime',
        'aktif' => 'boolean'
    ];

    public function guruKelas(): BelongsTo
    {
        return $this->belongsTo(GuruKelas::class);
    }

    public function soals(): HasMany
    {
        return $this->hasMany(Soal::class);
    }

    public function getStatusAttribute()
    {
        if (!$this->aktif) return 'nonaktif';
        if ($this->tanggal_terbit && $this->tanggal_terbit > now()) return 'belum_terbit';
        if ($this->batas_waktu < now()) return 'expired';
        return 'aktif';
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)
            ->where(function ($q) {
                $q->whereNull('tanggal_terbit')
                    ->orWhere('tanggal_terbit', '<=', now());
            });
    }

    public function scopeForKelas($query, $kelasId)
    {
        return $query->whereHas('guruKelas', function ($q) use ($kelasId) {
            $q->where('kelas_id', $kelasId);
        });
    }

    // public function guruMataPelajaran()
    // {
    //     return $this->belongsTo(GuruMataPelajaran::class, 'guru_mata_pelajaran_id');
    // }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }
}
