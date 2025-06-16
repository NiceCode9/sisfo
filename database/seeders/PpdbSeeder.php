<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;
use App\Models\JalurPendaftaran;
use App\Models\KuotaPendaftaran;
use App\Models\BiayaPendaftaran;
use App\Models\JadwalPpdb;

class PpdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seeder Tahun Ajaran
        $tahunAjaran = [
            [
                'nama_tahun_ajaran' => '2024/2025',
                'tanggal_mulai' => '2024-07-01',
                'tanggal_selesai' => '2025-06-30',
                'status_aktif' => true
            ],
            [
                'nama_tahun_ajaran' => '2025/2026',
                'tanggal_mulai' => '2025-07-01',
                'tanggal_selesai' => '2026-06-30',
                'status_aktif' => false
            ],
            [
                'nama_tahun_ajaran' => '2023/2024',
                'tanggal_mulai' => '2023-07-01',
                'tanggal_selesai' => '2024-06-30',
                'status_aktif' => false
            ],
            [
                'nama_tahun_ajaran' => '2022/2023',
                'tanggal_mulai' => '2022-07-01',
                'tanggal_selesai' => '2023-06-30',
                'status_aktif' => false
            ],
        ];

        foreach ($tahunAjaran as $ta) {
            TahunAjaran::create($ta);
        }

        // 2. Seeder Jalur Pendaftaran
        $jalurPendaftaran = [
            [
                'nama_jalur' => 'Jalur Reguler',
                'deskripsi' => 'Jalur pendaftaran untuk siswa umum dengan sistem seleksi berdasarkan nilai akademik',
                'aktif' => true
            ],
            [
                'nama_jalur' => 'Jalur Prestasi',
                'deskripsi' => 'Jalur pendaftaran untuk siswa berprestasi akademik atau non-akademik',
                'aktif' => true
            ],
            [
                'nama_jalur' => 'Jalur Afirmasi',
                'deskripsi' => 'Jalur pendaftaran untuk siswa dari keluarga kurang mampu',
                'aktif' => true
            ],
            [
                'nama_jalur' => 'Jalur Mutasi',
                'deskripsi' => 'Jalur pendaftaran untuk siswa pindahan dari sekolah lain',
                'aktif' => true
            ]
        ];

        foreach ($jalurPendaftaran as $jalur) {
            JalurPendaftaran::create($jalur);
        }

        // 3. Seeder Kuota Pendaftaran
        $tahunAjaranAktif = TahunAjaran::where('status_aktif', true)->first();
        $jalurIds = JalurPendaftaran::where('aktif', true)->pluck('id')->toArray();

        $kuotaPendaftaran = [
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'jalur_pendaftaran_id' => $jalurIds[0], // Jalur Reguler
                'kuota' => 200,
                'terisi' => 150,
                'keterangan' => 'Kuota untuk jalur reguler tahun ajaran 2024/2025'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'jalur_pendaftaran_id' => $jalurIds[1], // Jalur Prestasi
                'kuota' => 50,
                'terisi' => 35,
                'keterangan' => 'Kuota untuk jalur prestasi tahun ajaran 2024/2025'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'jalur_pendaftaran_id' => $jalurIds[2], // Jalur Afirmasi
                'kuota' => 30,
                'terisi' => 20,
                'keterangan' => 'Kuota untuk jalur afirmasi tahun ajaran 2024/2025'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'jalur_pendaftaran_id' => $jalurIds[3], // Jalur Mutasi
                'kuota' => 20,
                'terisi' => 5,
                'keterangan' => 'Kuota untuk jalur mutasi tahun ajaran 2024/2025'
            ]
        ];

        foreach ($kuotaPendaftaran as $kuota) {
            KuotaPendaftaran::create($kuota);
        }

        // 4. Seeder Biaya Pendaftaran
        $biayaPendaftaran = [
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'jenis_biaya' => 'Biaya Pendaftaran',
                'jumlah' => 100000,
                'mata_uang' => 'IDR',
                'wajib_bayar' => true,
                'keterangan' => 'Biaya administrasi pendaftaran PPDB'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'jenis_biaya' => 'Uang Pangkal',
                'jumlah' => 2500000,
                'mata_uang' => 'IDR',
                'wajib_bayar' => true,
                'keterangan' => 'Uang pangkal untuk siswa baru'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'jenis_biaya' => 'Seragam',
                'jumlah' => 500000,
                'mata_uang' => 'IDR',
                'wajib_bayar' => true,
                'keterangan' => 'Biaya pembelian seragam sekolah'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'jenis_biaya' => 'Buku Paket',
                'jumlah' => 750000,
                'mata_uang' => 'IDR',
                'wajib_bayar' => true,
                'keterangan' => 'Biaya pembelian buku paket pelajaran'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'jenis_biaya' => 'Ekstrakurikuler',
                'jumlah' => 200000,
                'mata_uang' => 'IDR',
                'wajib_bayar' => false,
                'keterangan' => 'Biaya kegiatan ekstrakurikuler (opsional)'
            ]
        ];

        foreach ($biayaPendaftaran as $biaya) {
            BiayaPendaftaran::create($biaya);
        }

        // 5. Seeder Jadwal PPDB
        $jadwalPpdb = [
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'nama_jadwal' => 'Pendaftaran Online',
                'tanggal_mulai' => '2024-05-01',
                'tanggal_selesai' => '2024-05-31',
                'keterangan' => 'Periode pendaftaran online untuk calon siswa baru'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'nama_jadwal' => 'Verifikasi Berkas',
                'tanggal_mulai' => '2024-06-01',
                'tanggal_selesai' => '2024-06-10',
                'keterangan' => 'Periode verifikasi berkas pendaftaran'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'nama_jadwal' => 'Tes Seleksi',
                'tanggal_mulai' => '2024-06-15',
                'tanggal_selesai' => '2024-06-20',
                'keterangan' => 'Pelaksanaan tes seleksi untuk calon siswa'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'nama_jadwal' => 'Pengumuman Hasil',
                'tanggal_mulai' => '2024-06-25',
                'tanggal_selesai' => '2024-06-25',
                'keterangan' => 'Pengumuman hasil seleksi PPDB'
            ],
            [
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'nama_jadwal' => 'Daftar Ulang',
                'tanggal_mulai' => '2024-06-26',
                'tanggal_selesai' => '2024-06-30',
                'keterangan' => 'Periode daftar ulang untuk siswa yang diterima'
            ]
        ];

        foreach ($jadwalPpdb as $jadwal) {
            JadwalPpdb::create($jadwal);
        }

        echo "Seeder PPDB berhasil dijalankan!\n";
        echo "Data yang dibuat:\n";
    }
}
