<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'guru_kelas_id',
        'tahun_ajaran_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan'
    ];

    protected $casts = [
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'hari' => 'string'
    ];

    // Relasi dengan GuruKelas
    public function guruKelas(): BelongsTo
    {
        return $this->belongsTo(GuruKelas::class);
    }

    // Relasi dengan TahunAjaran
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    // Accessor untuk mendapatkan info lengkap
    public function getInfoLengkapAttribute()
    {
        return [
            'guru' => $this->guruKelas->guru->name ?? null,
            'mata_pelajaran' => $this->guruKelas->mata_pelajaran->nama_pelajaran ?? null,
            'kelas' => $this->guruKelas->kelas->nama_kelas ?? null,
            'hari' => $this->hari,
            'waktu' => $this->asDateTime($this->jam_mulai)->format('H:i') . ' - ' . $this->asDateTime($this->jam_selesai)->format('H:i'),
            'ruangan' => $this->ruangan,
        ];
    }
}
