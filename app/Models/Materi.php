<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Materi extends Model
{
    protected $table = 'materi';

    protected $fillable = [
        'guru_kelas_id',
        'judul',
        'konten',
        'path_file',
        'diterbitkan',
        'visibilitas',
        'tanggal_terbit'
    ];

    protected $casts = [
        'diterbitkan' => 'boolean',
        'tanggal_terbit' => 'datetime',
        'visibilitas' => 'string'
    ];

    public function guruKelas(): BelongsTo
    {
        return $this->belongsTo(GuruKelas::class);
    }

    // Accessor untuk cek apakah materi sudah publish
    public function getIsPublishedAttribute()
    {
        return $this->diterbitkan &&
            ($this->tanggal_terbit === null || $this->tanggal_terbit <= now());
    }

    public function scopePublished($query)
    {
        return $query->where('diterbitkan', true)
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

    // public function gurus(): BelongsToMany
    // {
    //     return $this->belongsToMany(Guru::class, 'guru_mata_pelajaran')
    //         ->withPivot('keterangan')
    //         ->withTimestamps();
    // }

    // public function guruMataPelajaran()
    // {
    //     return $this->belongsTo(GuruMataPelajaran::class, 'guru_mata_pelajaran_id');
    // }
}
