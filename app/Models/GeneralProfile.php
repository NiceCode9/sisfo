<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralProfile extends Model
{
    protected $fillable = [
        'nama_sekolah',
        'nama_kepsek',
        'alamat',
        'telp',
        'email',
        'map',
        'sosmed',
        'visi',
        'misi',
        'logo',
        'favicon',
        'tahun_berdiri'
    ];

    protected $casts = [
        'misi' => 'array',
        'sosmed' => 'array',
    ];
}
