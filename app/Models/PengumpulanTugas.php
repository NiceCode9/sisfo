<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'teks_pengumpulan',
        'path_file',
        'waktu_pengumpulan',
        'nilai',
        'umpan_balik'
    ];

    protected $casts = [
        'waktu_pengumpulan' => 'datetime',
        'nilai' => 'integer'
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class, 'pengumpulan_id');
    }
}
