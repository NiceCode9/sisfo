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
                'alamat' => 'Jl. Pendidikan No. 10, Jakarta',
                'gelar' => 'M.Pd.',
                'telp' => '081234567890',
            ],
            [
                'nip' => '198203152005042002',
                'biografi' => 'Guru bahasa Indonesia berpengalaman dengan spesialisasi sastra dan linguistik.',
                'bidang_keahlian' => 'Bahasa Indonesia, Sastra, Linguistik',
                'alamat' => 'Jl. Kebudayaan No. 5, Bandung',
                'gelar' => 'M.Hum.',
                'telp' => '082345678901',
            ],
            [
                'nip' => '198507202010121003',
                'biografi' => 'Guru bahasa Inggris dengan sertifikat TOEFL dan pengalaman mengajar internasional.',
                'bidang_keahlian' => 'Bahasa Inggris, TOEFL, Grammar',
                'alamat' => 'Jl. Global No. 20, Surabaya',
                'gelar' => 'M.A.',
                'telp' => '083456789012',
            ],
            [
                'nip' => '197912102005011004',
                'biografi' => 'Guru fisika dengan latar belakang penelitian di bidang fisika teoretis.',
                'bidang_keahlian' => 'Fisika, Mekanika, Termodinamika',
                'alamat' => 'Jl. Sains No. 15, Yogyakarta',
                'gelar' => 'M.Sc.',
                'telp' => '084567890123',
            ],
            [
                'nip' => '198406152009022005',
                'biografi' => 'Guru kimia dengan pengalaman laboratorium dan penelitian kimia organik.',
                'bidang_keahlian' => 'Kimia Organik, Kimia Analitik, Laboratorium',
                'alamat' => 'Jl. Kimia No. 8, Malang',
                'gelar' => 'M.Sc.',
                'telp' => '085678901234',
            ],
            [
                'nip' => '198105252006041006',
                'biografi' => 'Guru biologi dengan spesialisasi ekologi dan konservasi lingkungan.',
                'bidang_keahlian' => 'Biologi, Ekologi, Lingkungan',
                'alamat' => 'Jl. Alam No. 12, Semarang',
                'gelar' => 'M.Sc.',
                'telp' => '086789012345',
            ],
            [
                'nip' => '197809182003121007',
                'biografi' => 'Guru sejarah dengan keahlian khusus sejarah Indonesia dan metodologi penelitian sejarah.',
                'bidang_keahlian' => 'Sejarah Indonesia, Sejarah Dunia, Metodologi',
                'alamat' => 'Jl. Sejarah No. 3, Bali',
                'gelar' => 'M.Hum.',
                'telp' => '087890123456',
            ],
            [
                'nip' => '198201202007031008',
                'biografi' => 'Guru geografi dengan pengalaman penelitian sistem informasi geografis (GIS).',
                'bidang_keahlian' => 'Geografi, GIS, Kartografi',
                'alamat' => 'Jl. Geografi No. 7, Medan',
                'gelar' => 'M.Sc.',
                'telp' => '088901234567',
            ],
        ];

        foreach ($guruData as $guru) {
            Guru::create($guru);
        }
    }
}
