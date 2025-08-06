<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranEkskul extends Model
{
    protected $fillable = [
        'siswa_id',
        'ekstrakurikuler_id',
        'tahun_ajaran_id',
        'tanggal_daftar',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'status' => 'boolean',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function scopeByTahunAjaran($query, $tahunAjaranId)
    {
        return $query->where('tahun_ajaran_id', $tahunAjaranId);
    }

    public function scopeByEkstrakurikuler($query, $ekstrakurikulerId)
    {
        return $query->where('ekstrakurikuler_id', $ekstrakurikulerId);
    }

    public function getTanggalDaftarFormattedAttribute()
    {
        return $this->tanggal_daftar ? $this->tanggal_daftar->format('d/m/Y') : '-';
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Aktif' : 'Nonaktif';
    }
}
