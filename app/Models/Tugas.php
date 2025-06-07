<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'guru_mata_pelajaran_id',
        'judul',
        'deskripsi',
        'batas_waktu',
        'total_nilai',
        'jenis',
        'metode_pengerjaan',
        'file_tugas'
    ];

    protected $casts = [
        'batas_waktu' => 'datetime'
    ];

    public function guruMataPelajaran()
    {
        return $this->belongsTo(GuruMataPelajaran::class, 'guru_mata_pelajaran_id');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }
}
