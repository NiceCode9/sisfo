<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mataPelajaranData = [
            [
                'nama_pelajaran' => 'Matematika',
                'kode_pelajaran' => 'MTK',
                'deskripsi' => 'Mata pelajaran matematika untuk semua tingkat',
            ],
            [
                'nama_pelajaran' => 'Bahasa Indonesia',
                'kode_pelajaran' => 'BIN',
                'deskripsi' => 'Mata pelajaran bahasa Indonesia',
            ],
            [
                'nama_pelajaran' => 'Bahasa Inggris',
                'kode_pelajaran' => 'BIG',
                'deskripsi' => 'Mata pelajaran bahasa Inggris',
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
                'deskripsi' => 'Mata pelajaran sejarah untuk jurusan IPS',
            ],
            [
                'nama_pelajaran' => 'Geografi',
                'kode_pelajaran' => 'GEO',
                'deskripsi' => 'Mata pelajaran geografi untuk jurusan IPS',
            ],
            [
                'nama_pelajaran' => 'Ekonomi',
                'kode_pelajaran' => 'EKO',
                'deskripsi' => 'Mata pelajaran ekonomi untuk jurusan IPS',
            ],
            [
                'nama_pelajaran' => 'Sosiologi',
                'kode_pelajaran' => 'SOS',
                'deskripsi' => 'Mata pelajaran sosiologi untuk jurusan IPS',
            ],
        ];

        foreach ($mataPelajaranData as $mataPelajaran) {
            MataPelajaran::create($mataPelajaran);
        }
    }
}
