<?php

namespace Database\Seeders;

use App\Models\GuruKelas;
use App\Models\GuruMataPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruKelasSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaranAktif = TahunAjaran::where('status_aktif', 1)->first();
        $kelasList = Kelas::all();
        $guruMataPelajaranList = GuruMataPelajaran::with(['guru', 'mataPelajaran'])->get();

        $guruKelasData = [];

        foreach ($kelasList as $kelas) {
            foreach ($guruMataPelajaranList as $guruMataPelajaran) {
                $mataPelajaran = $guruMataPelajaran->mataPelajaran;

                // Logika penempatan guru ke kelas berdasarkan jurusan
                $shouldAssign = false;

                switch ($mataPelajaran->kode_pelajaran) {
                    case 'MTK':
                    case 'BIND':
                    case 'BING':
                    case 'SEJ':
                        // Mata pelajaran umum untuk semua jurusan
                        $shouldAssign = true;
                        break;

                    case 'FIS':
                    case 'KIM':
                    case 'BIO':
                        // Mata pelajaran khusus IPA
                        $shouldAssign = ($kelas->jurusan === 'IPA');
                        break;

                    case 'GEO':
                        // Mata pelajaran khusus IPS dan sebagai mata pelajaran umum
                        $shouldAssign = ($kelas->jurusan === 'IPS') ||
                            ($kelas->tingkat === 10); // Kelas X umum
                        break;
                }

                if ($shouldAssign) {
                    $guruKelasData[] = [
                        'guru_mata_pelajaran_id' => $guruMataPelajaran->id,
                        'kelas_id' => $kelas->id,
                        'tahun_ajaran_id' => $tahunAjaranAktif->id,
                        'aktif' => true,
                        'keterangan' => "Pengampu {$mataPelajaran->nama_pelajaran} di {$kelas->nama_kelas} tahun ajaran {$tahunAjaranAktif->tahun}",
                    ];
                }
            }
        }

        foreach ($guruKelasData as $data) {
            GuruKelas::create($data);
        }
    }
}
