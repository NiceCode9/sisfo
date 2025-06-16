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
            ->get();

        // ID counter
        $id = 1;

        // Siswa baru dari calon siswa (kelas X) - maksimal 30 siswa
        $siswaBaruCount = 0;
        foreach ($calonSiswaDiterima as $calonSiswa) {
            if ($siswaBaruCount >= 30) break;

            $data[] = [
                'id' => $id++,
                'calon_siswa_id' => $calonSiswa->id,
                'tahun_ajaran_id' => 2, // 2024/2025
                'nis' => '2024' . str_pad($siswaBaruCount + 1, 4, '0', STR_PAD_LEFT),
                'nisn' => $calonSiswa->nisn,
                'kelas_awal' => 'X',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $siswaBaruCount++;
        }

        // Jika calon siswa yang diterima kurang dari 30, buat data dummy calon siswa
        if ($siswaBaruCount < 30) {
            $dummyCalonSiswa = [];
            for ($i = $siswaBaruCount; $i < 30; $i++) {
                $gender = $faker->randomElement(['L', 'P']);
                $firstName = $gender === 'L' ? $faker->firstNameMale : $faker->firstNameFemale;

                $dummyCalonSiswa[] = [
                    'jalur_pendaftaran_id' => $faker->numberBetween(1, 4),
                    'no_pendaftaran' => 'REG' . str_pad(51 + $i, 4, '0', STR_PAD_LEFT),
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
                    'tahun_ajaran_id' => 2,
                    'status_pendaftaran' => 'diterima',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert dummy calon siswa
            DB::table('calon_siswa')->insert($dummyCalonSiswa);

            // Ambil ID calon siswa yang baru dibuat
            $newCalonSiswa = DB::table('calon_siswa')
                ->where('no_pendaftaran', 'like', 'REG005%')
                ->get();

            // Buat siswa dari dummy calon siswa
            foreach ($newCalonSiswa as $calonSiswa) {
                if ($siswaBaruCount >= 30) break;

                $data[] = [
                    'id' => $id++,
                    'calon_siswa_id' => $calonSiswa->id,
                    'tahun_ajaran_id' => 2,
                    'nis' => '2024' . str_pad($siswaBaruCount + 1, 4, '0', STR_PAD_LEFT),
                    'nisn' => $calonSiswa->nisn,
                    'kelas_awal' => 'X',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $siswaBaruCount++;
            }
        }

        // Siswa kelas XI (15 siswa) - buat dummy calon siswa untuk mereka
        $calonSiswaKelasXI = [];
        for ($i = 1; $i <= 15; $i++) {
            $gender = $faker->randomElement(['L', 'P']);
            $firstName = $gender === 'L' ? $faker->firstNameMale : $faker->firstNameFemale;

            $calonSiswaKelasXI[] = [
                'jalur_pendaftaran_id' => $faker->numberBetween(1, 4),
                'no_pendaftaran' => 'REG2023' . str_pad($i, 3, '0', STR_PAD_LEFT),
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
                'tahun_ajaran_id' => 1,
                'status_pendaftaran' => 'diterima',
                'created_at' => now()->subYear(),
                'updated_at' => now()->subYear(),
            ];
        }

        DB::table('calon_siswa')->insert($calonSiswaKelasXI);

        // Ambil calon siswa kelas XI yang baru dibuat
        $calonSiswaXI = DB::table('calon_siswa')
            ->where('no_pendaftaran', 'like', 'REG2023%')
            ->get();

        foreach ($calonSiswaXI as $calonSiswa) {
            $data[] = [
                'id' => $id++,
                'calon_siswa_id' => $calonSiswa->id,
                'tahun_ajaran_id' => 1,
                'nis' => '2023' . str_pad($id - 31, 4, '0', STR_PAD_LEFT),
                'nisn' => $calonSiswa->nisn,
                'kelas_awal' => 'X',
                'created_at' => now()->subYear(),
                'updated_at' => now()->subYear(),
            ];
        }

        // Siswa kelas XII (15 siswa) - buat dummy calon siswa untuk mereka
        $calonSiswaKelasXII = [];
        for ($i = 1; $i <= 15; $i++) {
            $gender = $faker->randomElement(['L', 'P']);
            $firstName = $gender === 'L' ? $faker->firstNameMale : $faker->firstNameFemale;

            $calonSiswaKelasXII[] = [
                'jalur_pendaftaran_id' => $faker->numberBetween(1, 4),
                'no_pendaftaran' => 'REG2022' . str_pad($i, 3, '0', STR_PAD_LEFT),
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
                'tahun_ajaran_id' => 1,
                'status_pendaftaran' => 'diterima',
                'created_at' => now()->subYears(2),
                'updated_at' => now()->subYears(2),
            ];
        }

        DB::table('calon_siswa')->insert($calonSiswaKelasXII);

        // Ambil calon siswa kelas XII yang baru dibuat
        $calonSiswaXII = DB::table('calon_siswa')
            ->where('no_pendaftaran', 'like', 'REG2022%')
            ->get();

        foreach ($calonSiswaXII as $calonSiswa) {
            $data[] = [
                'id' => $id++,
                'calon_siswa_id' => $calonSiswa->id,
                'tahun_ajaran_id' => 1,
                'nis' => '2022' . str_pad($id - 46, 4, '0', STR_PAD_LEFT),
                'nisn' => $calonSiswa->nisn,
                'kelas_awal' => 'X',
                'created_at' => now()->subYears(2),
                'updated_at' => now()->subYears(2),
            ];
        }

        DB::table('siswa')->insert($data);
    }
}
