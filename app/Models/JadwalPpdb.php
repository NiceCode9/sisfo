<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPpdb extends Model
{
    use HasFactory;

    protected $table = 'jadwal_ppdb';
    protected $fillable = [
        'tahun_ajaran_id',
        'nama_jadwal',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan'
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
