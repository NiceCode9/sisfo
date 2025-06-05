<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'jurusan',
        'deskripsi',
    ];

    /**
     * Get the siswa associated with the kelas.
     */
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}
