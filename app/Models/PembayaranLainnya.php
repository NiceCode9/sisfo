<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranLainnya extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_lainnya';
    protected $fillable = [
        'calon_siswa_id',
        'biaya_pendaftaran_id',
        'kode_pembayaran',
        'jumlah',
        'status'
    ];

    public function calonSiswa()
    {
        return $this->belongsTo(CalonSiswa::class);
    }

    public function biayaPendaftaran()
    {
        return $this->belongsTo(BiayaPendaftaran::class);
    }
}
