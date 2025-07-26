<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelasData = [
            [
                'nama_kelas' => 'A',
                'tingkat' => 7,
                'deskripsi' => 'Kelas 7 A untuk siswa tingkat pertama',
            ],
            [
                'nama_kelas' => 'B',
                'tingkat' => 7,
                'deskripsi' => 'Kelas X IPA 2 untuk siswa tingkat pertama',
            ],
            [
                'nama_kelas' => 'C',
                'tingkat' => 7,
                'deskripsi' => 'Kelas X IPS 1 untuk siswa tingkat pertama',
            ],
            [
                'nama_kelas' => 'XI IPA 1',
                'tingkat' => 11,
                'jurusan' => 'IPA',
                'deskripsi' => 'Kelas XI IPA 1 untuk siswa tingkat kedua jurusan IPA',
            ],
            [
                'nama_kelas' => 'XI IPS 1',
                'tingkat' => 11,
                'jurusan' => 'IPS',
                'deskripsi' => 'Kelas XI IPS 1 untuk siswa tingkat kedua jurusan IPS',
            ],
            [
                'nama_kelas' => 'XII IPA 1',
                'tingkat' => 12,
                'jurusan' => 'IPA',
                'deskripsi' => 'Kelas XII IPA 1 untuk siswa tingkat ketiga jurusan IPA',
            ],
        ];

        foreach ($kelasData as $kelas) {
            Kelas::create($kelas);
        }
    }
}
