<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RiwayatKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];
        $id = 1;

        // Ambil semua siswa
        $siswaList = DB::table('siswa')->get();

        // Ambil kelas berdasarkan tingkat
        $kelasX = DB::table('kelas')->where('tingkat', 10)->pluck('id')->toArray();
        $kelasXI = DB::table('kelas')->where('tingkat', 11)->pluck('id')->toArray();
        $kelasXII = DB::table('kelas')->where('tingkat', 12)->pluck('id')->toArray();

        // Pastikan ada kelas untuk setiap tingkat
        if (empty($kelasX) || empty($kelasXI) || empty($kelasXII)) {
            throw new \Exception('Pastikan tabel kelas sudah diisi dengan data tingkat 10, 11, dan 12');
        }

        foreach ($siswaList as $siswa) {
            // Siswa baru (ID 1-30) - masuk kelas X tahun 2024/2025
            if ($siswa->id <= 30) {
                $data[] = [
                    'id' => $id++,
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $faker->randomElement($kelasX),
                    'tahun_ajaran_id' => 2,
                    'status' => 'aktif',
                    'keterangan' => 'Siswa baru tahun ajaran 2024/2025',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            // Siswa kelas XI (ID 31-45)
            elseif ($siswa->id <= 45) {
                // Riwayat kelas X tahun lalu
                $data[] = [
                    'id' => $id++,
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $faker->randomElement($kelasX),
                    'tahun_ajaran_id' => 1,
                    'status' => 'lulus',
                    'keterangan' => 'Lulus dari kelas X',
                    'created_at' => now()->subYear(),
                    'updated_at' => now()->subYear(),
                ];

                // Kelas XI sekarang
                $data[] = [
                    'id' => $id++,
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $faker->randomElement($kelasXI),
                    'tahun_ajaran_id' => 2,
                    'status' => 'aktif',
                    'keterangan' => 'Naik ke kelas XI',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            // Siswa kelas XII (ID 46-60)
            else {
                // Riwayat kelas X dua tahun lalu
                $data[] = [
                    'id' => $id++,
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $faker->randomElement($kelasX),
                    'tahun_ajaran_id' => 1, // Seharusnya tahun ajaran yang lebih lama
                    'status' => 'lulus',
                    'keterangan' => 'Lulus dari kelas X',
                    'created_at' => now()->subYears(2),
                    'updated_at' => now()->subYears(2),
                ];

                // Riwayat kelas XI tahun lalu
                $data[] = [
                    'id' => $id++,
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $faker->randomElement($kelasXI),
                    'tahun_ajaran_id' => 1,
                    'status' => 'lulus',
                    'keterangan' => 'Lulus dari kelas XI',
                    'created_at' => now()->subYear(),
                    'updated_at' => now()->subYear(),
                ];

                // Kelas XII sekarang
                $data[] = [
                    'id' => $id++,
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $faker->randomElement($kelasXII),
                    'tahun_ajaran_id' => 2,
                    'status' => 'aktif',
                    'keterangan' => 'Naik ke kelas XII',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Kasus khusus: siswa pindah dan dropout
        // Pastikan siswa dengan ID ini ada
        if (DB::table('siswa')->where('id', 25)->exists()) {
            $data[] = [
                'id' => $id++,
                'siswa_id' => 25,
                'kelas_id' => $faker->randomElement($kelasX),
                'tahun_ajaran_id' => 2,
                'status' => 'pindah',
                'keterangan' => 'Pindah sekolah karena orang tua mutasi kerja',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (DB::table('siswa')->where('id', 26)->exists()) {
            $data[] = [
                'id' => $id++,
                'siswa_id' => 26,
                'kelas_id' => $faker->randomElement($kelasX),
                'tahun_ajaran_id' => 2,
                'status' => 'dropout',
                'keterangan' => 'Mengundurkan diri karena alasan pribadi',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data dalam batch untuk performa yang lebih baik
        $chunks = array_chunk($data, 100);
        foreach ($chunks as $chunk) {
            DB::table('riwayat_kelas')->insert($chunk);
        }
    }
}
