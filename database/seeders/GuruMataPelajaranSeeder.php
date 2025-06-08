<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GuruMataPelajaran;

class GuruMataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $guruMataPelajaranData = [
            // Guru Matematika mengajar Matematika
            ['guru_id' => 1, 'mata_pelajaran_id' => 1],

            // Guru Bahasa Indonesia mengajar Bahasa Indonesia
            ['guru_id' => 2, 'mata_pelajaran_id' => 2],

            // Guru Bahasa Inggris mengajar Bahasa Inggris
            ['guru_id' => 3, 'mata_pelajaran_id' => 3],

            // Guru Fisika mengajar Fisika dan Matematika
            ['guru_id' => 4, 'mata_pelajaran_id' => 4],
            ['guru_id' => 4, 'mata_pelajaran_id' => 1],

            // Guru Kimia mengajar Kimia
            ['guru_id' => 5, 'mata_pelajaran_id' => 5],

            // Guru Biologi mengajar Biologi
            ['guru_id' => 6, 'mata_pelajaran_id' => 6],

            // Guru Sejarah mengajar Sejarah
            ['guru_id' => 7, 'mata_pelajaran_id' => 7],

            // Guru Geografi mengajar Geografi dan Ekonomi
            ['guru_id' => 8, 'mata_pelajaran_id' => 8],
            ['guru_id' => 8, 'mata_pelajaran_id' => 9],
        ];

        foreach ($guruMataPelajaranData as $data) {
            GuruMataPelajaran::create($data);
        }
    }
}
