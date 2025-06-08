<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guruData = [
            [
                'nip' => '197501012000031001',
                'biografi' => 'Guru matematika dengan pengalaman mengajar 20 tahun. Lulusan S2 Pendidikan Matematika.',
                'bidang_keahlian' => 'Matematika, Statistika, Aljabar',
            ],
            [
                'nip' => '198203152005042002',
                'biografi' => 'Guru bahasa Indonesia berpengalaman dengan spesialisasi sastra dan linguistik.',
                'bidang_keahlian' => 'Bahasa Indonesia, Sastra, Linguistik',
            ],
            [
                'nip' => '198507202010121003',
                'biografi' => 'Guru bahasa Inggris dengan sertifikat TOEFL dan pengalaman mengajar internasional.',
                'bidang_keahlian' => 'Bahasa Inggris, TOEFL, Grammar',
            ],
            [
                'nip' => '197912102005011004',
                'biografi' => 'Guru fisika dengan latar belakang penelitian di bidang fisika teoretis.',
                'bidang_keahlian' => 'Fisika, Mekanika, Termodinamika',
            ],
            [
                'nip' => '198406152009022005',
                'biografi' => 'Guru kimia dengan pengalaman laboratorium dan penelitian kimia organik.',
                'bidang_keahlian' => 'Kimia Organik, Kimia Analitik, Laboratorium',
            ],
            [
                'nip' => '198105252006041006',
                'biografi' => 'Guru biologi dengan spesialisasi ekologi dan konservasi lingkungan.',
                'bidang_keahlian' => 'Biologi, Ekologi, Lingkungan',
            ],
            [
                'nip' => '197809182003121007',
                'biografi' => 'Guru sejarah dengan keahlian khusus sejarah Indonesia dan metodologi penelitian sejarah.',
                'bidang_keahlian' => 'Sejarah Indonesia, Sejarah Dunia, Metodologi',
            ],
            [
                'nip' => '198201202007031008',
                'biografi' => 'Guru geografi dengan pengalaman penelitian sistem informasi geografis (GIS).',
                'bidang_keahlian' => 'Geografi, GIS, Kartografi',
            ],
        ];

        foreach ($guruData as $guru) {
            Guru::create($guru);
        }
    }
}
