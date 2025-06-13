<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CalonSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $data = [];

        for ($i = 1; $i <= 50; $i++) {
            $gender = $faker->randomElement(['L', 'P']);
            $firstName = $gender === 'L' ? $faker->firstNameMale : $faker->firstNameFemale;

            // Tentukan status berdasarkan ID untuk konsistensi
            $status = 'pending';
            if ($i <= 30) {
                $status = 'diterima'; // 30 siswa pertama diterima
            } elseif ($i <= 40) {
                $status = 'ditolak'; // 10 siswa ditolak
            } elseif ($i <= 45) {
                $status = 'verifikasi'; // 5 siswa dalam verifikasi
            }
            // sisanya pending (5 siswa)

            $data[] = [
                'id' => $i,
                'jalur_pendaftaran_id' => $faker->numberBetween(1, 4),
                'no_pendaftaran' => 'REG' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nik' => $faker->unique()->numerify('################'),
                'nisn' => $faker->unique()->numerify('##########'),
                'nama_lengkap' => $firstName . ' ' . $faker->lastName,
                'jenis_kelamin' => $gender,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->dateTimeBetween('-18 years', '-15 years')->format('Y-m-d'),
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
                'email' => $faker->unique()->email,
                'asal_sekolah' => 'SMP ' . $faker->city,
                'nama_ayah' => $faker->name('male'),
                'pekerjaan_ayah' => $faker->jobTitle,
                'nama_ibu' => $faker->name('female'),
                'pekerjaan_ibu' => $faker->jobTitle,
                'no_hp_orang_tua' => $faker->phoneNumber,
                'tahun_ajaran_id' => 2, // 2024/2025
                'status_pendaftaran' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('calon_siswa')->insert($data);
    }
}
