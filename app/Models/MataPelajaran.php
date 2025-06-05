<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama_pelajaran',
        'deskripsi',
        'kode_pelajaran',
    ];

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_mata_pelajaran', 'mata_pelajaran_id', 'guru_id')
            ->withTimestamps();
    }
    public function guruMataPelajaran()
    {
        return $this->hasMany(GuruMataPelajaran::class, 'mata_pelajaran_id');
    }
}
