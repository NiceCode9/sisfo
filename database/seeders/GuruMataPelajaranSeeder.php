<?php

namespace Database\Seeders;

use App\Models\GuruMataPelajaran;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruMataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        // Mendapatkan data guru dan mata pelajaran
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();

        // Mapping guru dengan mata pelajaran berdasarkan keahlian
        $guruMataPelajaranData = [
            // Guru Matematika (ID 1) - NIP: 197501012000031001
            [
                'guru_id' => 1,
                'mata_pelajaran_id' => $mataPelajarans->where('kode_pelajaran', 'MTK')->first()->id,
                'keterangan' => 'Guru mata pelajaran matematika tingkat SMA',
            ],

            // Guru Bahasa Indonesia (ID 2) - NIP: 198203152005042002
            [
                'guru_id' => 2,
                'mata_pelajaran_id' => $mataPelajarans->where('kode_pelajaran', 'BIND')->first()->id,
                'keterangan' => 'Guru mata pelajaran bahasa Indonesia tingkat SMA',
            ],

            // Guru Bahasa Inggris (ID 3) - NIP: 198507202010121003
            [
                'guru_id' => 3,
                'mata_pelajaran_id' => $mataPelajarans->where('kode_pelajaran', 'BING')->first()->id,
                'keterangan' => 'Guru mata pelajaran bahasa Inggris tingkat SMA',
            ],

            // Guru Fisika (ID 4) - NIP: 197912102005011004
            [
                'guru_id' => 4,
                'mata_pelajaran_id' => $mataPelajarans->where('kode_pelajaran', 'FIS')->first()->id,
                'keterangan' => 'Guru mata pelajaran fisika untuk jurusan IPA',
            ],

            // Guru Kimia (ID 5) - NIP: 198406152009022005
            [
                'guru_id' => 5,
                'mata_pelajaran_id' => $mataPelajarans->where('kode_pelajaran', 'KIM')->first()->id,
                'keterangan' => 'Guru mata pelajaran kimia untuk jurusan IPA',
            ],

            // Guru Biologi (ID 6) - NIP: 198105252006041006
            [
                'guru_id' => 6,
                'mata_pelajaran_id' => $mataPelajarans->where('kode_pelajaran', 'BIO')->first()->id,
                'keterangan' => 'Guru mata pelajaran biologi untuk jurusan IPA',
            ],

            // Guru Sejarah (ID 7) - NIP: 197809182003121007
            [
                'guru_id' => 7,
                'mata_pelajaran_id' => $mataPelajarans->where('kode_pelajaran', 'SEJ')->first()->id,
                'keterangan' => 'Guru mata pelajaran sejarah tingkat SMA',
            ],

            // Guru Geografi (ID 8) - NIP: 198201202007031008
            [
                'guru_id' => 8,
                'mata_pelajaran_id' => $mataPelajarans->where('kode_pelajaran', 'GEO')->first()->id,
                'keterangan' => 'Guru mata pelajaran geografi untuk jurusan IPS',
            ],
        ];

        foreach ($guruMataPelajaranData as $data) {
            GuruMataPelajaran::create($data);
        }
    }
}
