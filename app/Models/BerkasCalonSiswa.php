<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasCalonSiswa extends Model
{
    use HasFactory;

    protected $table = 'berkas_calon_siswa';
    protected $fillable = [
        'calon_siswa_id',
        'ijazah_path',
        'kk_path',
        'akta_path',
        'foto_path',
        'skl_path',
        'catatan_berkas',
        'status_verifikasi'
    ];

    public function calonSiswa()
    {
        return $this->belongsTo(CalonSiswa::class);
    }
}
