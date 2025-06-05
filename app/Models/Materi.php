<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';

    protected $fillable = [
        'guru_mata_pelajaran_id',
        'judul',
        'konten',
        'path_file',
        'diterbitkan',
    ];

    public function guruMataPelajaran()
    {
        return $this->belongsTo(GuruMataPelajaran::class, 'guru_mata_pelajaran_id');
    }
}
