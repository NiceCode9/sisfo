<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GallerySekolah extends Model
{
    protected $fillable = [
        'path',
        'judul',
        'deskripsi',
        'kategori',
        // 'is_cover'
    ];

    // protected $casts = [
    //     'is_cover' => 'boolean',
    // ];

    // Kategori constants
    const KATEGORI_KEGIATAN = 'kegiatan';
    const KATEGORI_FASILITAS = 'fasilitas';
    const KATEGORI_PRESTASI = 'prestasi';
    const KATEGORI_LAINNYA = 'lainnya';

    public static function getKategoriList()
    {
        return [
            self::KATEGORI_KEGIATAN => 'Kegiatan Sekolah',
            self::KATEGORI_FASILITAS => 'Fasilitas Sekolah',
            self::KATEGORI_PRESTASI => 'Prestasi Sekolah',
            self::KATEGORI_LAINNYA => 'Lainnya',
        ];
    }
}
