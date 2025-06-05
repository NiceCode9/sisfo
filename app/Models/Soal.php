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
        'poin'
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    // Uncomment if you have a model for jawaban
    // public function jawaban()
    // {
    //     return $this->hasMany(Jawaban::class, 'soal_id');
    // }
}
