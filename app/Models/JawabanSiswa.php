<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    protected $fillable = [
        'pengumpulan_id',
        'soal_id',
        'jawaban_teks',
        'id_jawaban',
        'poin_diperoleh'
    ];

    protected $casts = [
        'poin_diperoleh' => 'integer'
    ];

    public function pengumpulanTugas()
    {
        return $this->belongsTo(PengumpulanTugas::class, 'pengumpulan_id');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id');
    }

    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class, 'id_jawaban');
    }
}
