<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';

    protected $fillable = [
        'tugas_id',
        'pertanyaan',
        'jenis_soal',
        'poin',
        'urutan',
    ];

    protected $casts = [
        'poin' => 'integer',
        'urutan' => 'integer'
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class);
    }
}
