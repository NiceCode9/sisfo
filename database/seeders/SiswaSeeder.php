<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $data = [];

        // Ambil calon siswa yang diterima untuk dijadikan siswa baru (kelas X)
        $calonSiswaDiterima = DB::table('calon_siswa')
            ->where('status_pendaftaran', 'diterima')
            ->take(30)
            ->get();

        // ID counter
        $id = 1;

        // Siswa baru dari calon siswa (kelas X)
        foreach ($calonSiswaDiterima as $calonSiswa) {
            $data[] = [
                'id' => $id++,
                'calon_siswa_id' => $calonSiswa->id,
                'tahun_ajaran_id' => 2, // 2024/2025
                'nis' => '2024' . str_pad($id - 1, 4, '0', STR_PAD_LEFT),
                'nisn' => $calonSiswa->nisn,
                'kelas_awal' => 'X',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Siswa kelas XI (15 siswa)
        for ($i = 1; $i <= 15; $i++) {
            $gender = $faker->randomElement(['L', 'P']);
            $firstName = $gender === 'L' ? $faker->firstNameMale : $faker->firstNameFemale;

            $data[] = [
                'id' => $id++,
                'calon_siswa_id' => null,
                'tahun_ajaran_id' => 1, // Masuk tahun lalu
                'nis' => '2023' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nisn' => $faker->unique()->numerify('##########'),
                'kelas_awal' => 'X',
                'created_at' => now()->subYear(),
                'updated_at' => now()->subYear(),
            ];
        }

        // Siswa kelas XII (15 siswa)
        for ($i = 1; $i <= 15; $i++) {
            $gender = $faker->randomElement(['L', 'P']);
            $firstName = $gender === 'L' ? $faker->firstNameMale : $faker->firstNameFemale;

            $data[] = [
                'id' => $id++,
                'calon_siswa_id' => null,
                'tahun_ajaran_id' => 1, // Masuk 2 tahun lalu
                'nis' => '2022' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nisn' => $faker->unique()->numerify('##########'),
                'kelas_awal' => 'X',
                'created_at' => now()->subYears(2),
                'updated_at' => now()->subYears(2),
            ];
        }

        DB::table('siswa')->insert($data);
    }
}
