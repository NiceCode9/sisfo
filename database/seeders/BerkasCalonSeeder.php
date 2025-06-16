<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BerkasCalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

        // Ambil semua calon siswa
        $calonSiswaList = DB::table('calon_siswa')->get();

        foreach ($calonSiswaList as $calonSiswa) {
            $statusVerifikasi = $faker->boolean(80); // 80% chance of being verified

            $data[] = [
                'calon_siswa_id' => $calonSiswa->id,
                'ijazah_path' => 'berkas/' . $calonSiswa->id . '/ijazah.pdf',
                'kk_path' => 'berkas/' . $calonSiswa->id . '/kk.pdf',
                'akta_path' => 'berkas/' . $calonSiswa->id . '/akta.pdf',
                'foto_path' => 'berkas/' . $calonSiswa->id . '/foto.jpg',
                'skl_path' => 'berkas/' . $calonSiswa->id . '/skl.pdf',
                'catatan_berkas' => $statusVerifikasi ? null : $faker->randomElement([
                    'Berkas ijazah tidak jelas',
                    'Foto tidak sesuai ketentuan',
                    'Kartu keluarga perlu diperbaiki',
                    'Surat keterangan lulus belum lengkap'
                ]),
                'status_verifikasi' => $statusVerifikasi,
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ];

            // Insert dalam batch kecil untuk menghindari memory issues
            if (count($data) >= 50) {
                DB::table('berkas_calon_siswa')->insert($data);
                $data = [];
            }
        }

        // Insert sisa data
        if (!empty($data)) {
            DB::table('berkas_calon_siswa')->insert($data);
        }
    }
}
