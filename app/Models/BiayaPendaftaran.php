<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'biaya_pendaftaran';
    protected $fillable = [
        'tahun_ajaran_id',
        'jenis_biaya',
        'jumlah',
        'mata_uang',
        'wajib_bayar',
        'keterangan'
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
