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
        'jenis'
    ];

    public function guruMataPelajaran()
    {
        return $this->belongsTo(GuruMataPelajaran::class, 'id_guru_mata_pelajaran');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'id_tugas');
    }

    // public function pengumpulanTugas()
    // {
    //     return $this->hasMany(PengumpulanTugas::class, 'id_tugas');
    // }
}
