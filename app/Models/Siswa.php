<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $fillable = [
        'calon_siswa_id',
        'tahun_ajaran_id',
        'nis',
        'nisn',
        'kelas_awal'
    ];

    public function calonSiswa()
    {
        return $this->belongsTo(CalonSiswa::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
