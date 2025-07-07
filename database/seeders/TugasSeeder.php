<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data tugas, setiap tugas minimal 4 soal
        $tugasData = [
            [
                'tugas' => [
                    'guru_kelas_id' => 1,
                    'judul' => 'Latihan Matematika Dasar',
                    'deskripsi' => 'Latihan soal matematika untuk mengukur pemahaman siswa tentang operasi bilangan bulat.',
                    'batas_waktu' => Carbon::now()->addDays(7),
                    'total_nilai' => 100,
                    'jenis' => 'pilihan_ganda',
                    'metode_pengerjaan' => 'online',
                    'visibilitas' => 'kelas',
                    'tanggal_terbit' => Carbon::now(),
                    'aktif' => true,
                ],
                'soal' => [
                    [
                        'pertanyaan' => 'Hasil dari 15 + 8 - 5 × 2 adalah...',
                        'jenis_soal' => 'pilihan_ganda',
                        'poin' => 25,
                        'urutan' => 1,
                        'jawaban' => [
                            ['teks_jawaban' => '13', 'jawaban_benar' => true],
                            ['teks_jawaban' => '18', 'jawaban_benar' => false],
                            ['teks_jawaban' => '33', 'jawaban_benar' => false],
                            ['teks_jawaban' => '21', 'jawaban_benar' => false],
                        ]
                    ],
                    [
                        'pertanyaan' => 'Berapakah hasil dari 7 × 6?',
                        'jenis_soal' => 'pilihan_ganda',
                        'poin' => 25,
                        'urutan' => 2,
                        'jawaban' => [
                            ['teks_jawaban' => '42', 'jawaban_benar' => true],
                            ['teks_jawaban' => '36', 'jawaban_benar' => false],
                            ['teks_jawaban' => '48', 'jawaban_benar' => false],
                            ['teks_jawaban' => '56', 'jawaban_benar' => false],
                        ]
                    ],
                    [
                        'pertanyaan' => 'Berapakah akar kuadrat dari 81?',
                        'jenis_soal' => 'pilihan_ganda',
                        'poin' => 25,
                        'urutan' => 3,
                        'jawaban' => [
                            ['teks_jawaban' => '9', 'jawaban_benar' => true],
                            ['teks_jawaban' => '8', 'jawaban_benar' => false],
                            ['teks_jawaban' => '7', 'jawaban_benar' => false],
                            ['teks_jawaban' => '6', 'jawaban_benar' => false],
                        ]
                    ],
                    [
                        'pertanyaan' => 'Hasil dari 100 ÷ 4 adalah...',
                        'jenis_soal' => 'pilihan_ganda',
                        'poin' => 25,
                        'urutan' => 4,
                        'jawaban' => [
                            ['teks_jawaban' => '25', 'jawaban_benar' => true],
                            ['teks_jawaban' => '20', 'jawaban_benar' => false],
                            ['teks_jawaban' => '30', 'jawaban_benar' => false],
                            ['teks_jawaban' => '40', 'jawaban_benar' => false],
                        ]
                    ],
                ]
            ],
            [
                'tugas' => [
                    'guru_kelas_id' => 1,
                    'judul' => 'Pemahaman Teks Bahasa Indonesia',
                    'deskripsi' => 'Tugas untuk menganalisis struktur dan isi teks bacaan.',
                    'batas_waktu' => Carbon::now()->addDays(5),
                    'total_nilai' => 100,
                    'jenis' => 'uraian',
                    'metode_pengerjaan' => 'online',
                    'visibilitas' => 'kelas',
                    'tanggal_terbit' => Carbon::now(),
                    'aktif' => true,
                ],
                'soal' => [
                    [
                        'pertanyaan' => 'Jelaskan gagasan utama paragraf pertama!',
                        'jenis_soal' => 'uraian',
                        'poin' => 25,
                        'urutan' => 1,
                        'jawaban' => []
                    ],
                    [
                        'pertanyaan' => 'Apa tujuan penulis dalam paragraf kedua?',
                        'jenis_soal' => 'uraian',
                        'poin' => 25,
                        'urutan' => 2,
                        'jawaban' => []
                    ],
                    [
                        'pertanyaan' => 'Sebutkan 2 kata kunci dari teks bacaan!',
                        'jenis_soal' => 'uraian',
                        'poin' => 25,
                        'urutan' => 3,
                        'jawaban' => []
                    ],
                    [
                        'pertanyaan' => 'Buatlah ringkasan singkat dari teks di atas!',
                        'jenis_soal' => 'uraian',
                        'poin' => 25,
                        'urutan' => 4,
                        'jawaban' => []
                    ],
                ]
            ],
            [
                'tugas' => [
                    'guru_kelas_id' => 1, // Sesuaikan dengan ID guru_kelas yang ada
                    'judul' => 'Pengenalan Sistem Periodik',
                    'deskripsi' => 'Quiz tentang unsur-unsur kimia dan sistem periodik.',
                    'batas_waktu' => Carbon::now()->addDays(3),
                    'total_nilai' => 100,
                    'jenis' => 'pilihan_ganda',
                    'metode_pengerjaan' => 'online',
                    'visibilitas' => 'kelas',
                    'tanggal_terbit' => Carbon::now(),
                    'aktif' => true,
                ],
                'soal' => [
                    [
                        'pertanyaan' => 'Unsur dengan nomor atom 6 memiliki lambang...',
                        'jenis_soal' => 'pilihan_ganda',
                        'poin' => 33.3,
                        'urutan' => 1,
                        'jawaban' => [
                            ['teks_jawaban' => 'C', 'jawaban_benar' => true],
                            ['teks_jawaban' => 'N', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'O', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'B', 'jawaban_benar' => false],
                        ]
                    ],
                    [
                        'pertanyaan' => 'Unsur yang paling ringan dalam sistem periodik adalah...',
                        'jenis_soal' => 'pilihan_ganda',
                        'poin' => 33.3,
                        'urutan' => 2,
                        'jawaban' => [
                            ['teks_jawaban' => 'H', 'jawaban_benar' => true],
                            ['teks_jawaban' => 'He', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'Li', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'Be', 'jawaban_benar' => false],
                        ]
                    ],
                    [
                        'pertanyaan' => 'Lambang kimia untuk emas adalah...',
                        'jenis_soal' => 'pilihan_ganda',
                        'poin' => 33.3,
                        'urutan' => 3,
                        'jawaban' => [
                            ['teks_jawaban' => 'Au', 'jawaban_benar' => true],
                            ['teks_jawaban' => 'Ag', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'Pb', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'Fe', 'jawaban_benar' => false],
                        ]
                    ],
                    [
                        'pertanyaan' => 'Unsur yang memiliki nomor atom 1 adalah...',
                        'jenis_soal' => 'pilihan_ganda',
                        'poin' => 33.3,
                        'urutan' => 4,
                        'jawaban' => [
                            ['teks_jawaban' => 'H', 'jawaban_benar' => true],
                            ['teks_jawaban' => 'He', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'Li', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'Be', 'jawaban_benar' => false],
                        ]
                    ],
                ]
            ],
            [
                'tugas' => [
                    'guru_kelas_id' => 1,
                    'judul' => 'Sejarah Kemerdekaan Indonesia',
                    'deskripsi' => 'Esai tentang peristiwa-peristiwa penting menjelang kemerdekaan Indonesia.',
                    'batas_waktu' => Carbon::now()->addDays(10),
                    'total_nilai' => 100,
                    'jenis' => 'uraian',
                    'metode_pengerjaan' => 'upload_file',
                    'visibilitas' => 'kelas',
                    'tanggal_terbit' => Carbon::now(),
                    'aktif' => true,
                ],
                'soal' => [
                    [
                        'pertanyaan' => 'Jelaskan secara kronologis peristiwa-peristiwa penting yang terjadi pada tanggal 14-17 Agustus 1945 yang berkaitan dengan proklamasi kemerdekaan Indonesia!',
                        'jenis_soal' => 'uraian',
                        'poin' => 100,
                        'urutan' => 1,
                    ],
                ],
                'jawaban' => []
            ],
            [
                'tugas' => [
                    'guru_kelas_id' => 1, // Sesuaikan dengan ID guru_kelas yang ada
                    'judul' => 'Grammar Exercise - Present Tense',
                    'deskripsi' => 'Latihan soal tentang penggunaan Present Simple dan Present Continuous.',
                    'batas_waktu' => Carbon::now()->addDays(4),
                    'total_nilai' => 100,
                    'jenis' => 'pilihan_ganda',
                    'metode_pengerjaan' => 'online',
                    'visibilitas' => 'kelas',
                    'tanggal_terbit' => Carbon::now(),
                    'aktif' => true,
                ],
                'soal' => [
                    [
                        'pertanyaan' => 'Choose the correct form: "She _____ to school every day."',
                        'jenis_soal' => 'pilihan_ganda',
                        'poin' => 50,
                        'urutan' => 1,
                        'jawaban' => [
                            ['teks_jawaban' => 'goes', 'jawaban_benar' => true],
                            ['teks_jawaban' => 'go', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'going', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'gone', 'jawaban_benar' => false],
                        ]
                    ],
                    [
                        'pertanyaan' => 'Fill in the blank: "I _____ playing football when it started to rain."',
                        'jenis_soal' => 'pilihan_ganda',
                        'poin' => 50,
                        'urutan' => 2,
                        'jawaban' => [
                            ['teks_jawaban' => 'was', 'jawaban_benar' => true],
                            ['teks_jawaban' => 'am', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'is', 'jawaban_benar' => false],
                            ['teks_jawaban' => 'were', 'jawaban_benar' => false],
                        ]
                    ],
                ]
            ],
            [
                'tugas' => [
                    'guru_kelas_id' => 1,
                    'judul' => 'Fisika Gerak Lurus',
                    'deskripsi' => 'Perhitungan tentang gerak lurus beraturan dan gerak lurus berubah beraturan.',
                    'batas_waktu' => Carbon::now()->addDays(6),
                    'total_nilai' => 100,
                    'jenis' => 'campuran',
                    'metode_pengerjaan' => 'online',
                    'visibilitas' => 'kelas',
                    'tanggal_terbit' => Carbon::now(),
                    'aktif' => true,
                ],
                'soal' => [
                    [
                        'pertanyaan' => 'Sebuah mobil bergerak dengan kecepatan awal 10 m/s dan mengalami percepatan 2 m/s². Berapa jarak yang ditempuh mobil setelah 5 detik?',
                        'jenis_soal' => 'uraian',
                        'poin' => 100,
                        'urutan' => 1,
                    ],
                ],
                'jawaban' => []
            ]
        ];

        // Insert data
        foreach ($tugasData as $data) {
            $tugasId = DB::table('tugas')->insertGetId(array_merge($data['tugas'], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));

            foreach ($data['soal'] as $soalData) {
                $soalId = DB::table('soal')->insertGetId([
                    'tugas_id' => $tugasId,
                    'pertanyaan' => $soalData['pertanyaan'],
                    'jenis_soal' => $soalData['jenis_soal'],
                    'poin' => $soalData['poin'],
                    'urutan' => $soalData['urutan'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                if (!empty($soalData['jawaban'])) {
                    foreach ($soalData['jawaban'] as $jawaban) {
                        DB::table('jawaban')->insert([
                            'id_soal' => $soalId,
                            'teks_jawaban' => $jawaban['teks_jawaban'],
                            'jawaban_benar' => $jawaban['jawaban_benar'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
        }
    }
}
