<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawaban';

    protected $fillable = [
        'id_soal',
        'teks_jawaban',
        'jawaban_benar'
    ];

    protected $casts = [
        'jawaban_benar' => 'boolean'
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal');
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class, 'id_jawaban');
    }
}
