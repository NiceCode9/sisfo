<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mataPelajaranData = [
            [
                'nama_pelajaran' => 'Matematika',
                'kode_pelajaran' => 'MTK',
                'deskripsi' => 'Mata pelajaran matematika untuk tingkat SMA',
            ],
            [
                'nama_pelajaran' => 'Bahasa Indonesia',
                'kode_pelajaran' => 'BIND',
                'deskripsi' => 'Mata pelajaran bahasa Indonesia untuk tingkat SMA',
            ],
            [
                'nama_pelajaran' => 'Bahasa Inggris',
                'kode_pelajaran' => 'BING',
                'deskripsi' => 'Mata pelajaran bahasa Inggris untuk tingkat SMA',
            ],
            [
                'nama_pelajaran' => 'Fisika',
                'kode_pelajaran' => 'FIS',
                'deskripsi' => 'Mata pelajaran fisika untuk jurusan IPA',
            ],
            [
                'nama_pelajaran' => 'Kimia',
                'kode_pelajaran' => 'KIM',
                'deskripsi' => 'Mata pelajaran kimia untuk jurusan IPA',
            ],
            [
                'nama_pelajaran' => 'Biologi',
                'kode_pelajaran' => 'BIO',
                'deskripsi' => 'Mata pelajaran biologi untuk jurusan IPA',
            ],
            [
                'nama_pelajaran' => 'Sejarah',
                'kode_pelajaran' => 'SEJ',
                'deskripsi' => 'Mata pelajaran sejarah untuk tingkat SMA',
            ],
            [
                'nama_pelajaran' => 'Geografi',
                'kode_pelajaran' => 'GEO',
                'deskripsi' => 'Mata pelajaran geografi untuk jurusan IPS',
            ],
        ];

        foreach ($mataPelajaranData as $mataPelajaran) {
            MataPelajaran::create($mataPelajaran);
        }
    }
}
