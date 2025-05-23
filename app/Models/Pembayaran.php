<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $fillable = [
        'calon_siswa_id',
        'kode_pembayaran',
        'jumlah',
        'metode_pembayaran',
        'bukti_pembayaran_path',
        'tanggal_pembayaran',
        'status',
        'catatan'
    ];

    public function calonSiswa()
    {
        return $this->belongsTo(CalonSiswa::class);
    }
}
