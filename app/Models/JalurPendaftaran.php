<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JalurPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'jalur_pendaftaran';
    protected $fillable = [
        'nama_jalur',
        'deskripsi',
        'aktif'
    ];

    public function kuotaPendaftaran()
    {
        return $this->hasMany(KuotaPendaftaran::class);
    }

    public function calonSiswa()
    {
        return $this->hasMany(CalonSiswa::class);
    }
}
