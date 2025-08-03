<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranEkskul extends Model
{
    protected $fillable = [
        'siswa_id',
        'ekstrakulikuler_id',
        'tahun_ajaran_id',
        'tanggal_daftar',
        'catatan',
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
}
