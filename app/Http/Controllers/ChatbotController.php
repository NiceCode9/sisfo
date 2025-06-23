<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TahunAjaran;
use App\Models\JadwalPpdb;
use App\Models\JalurPendaftaran;
use App\Models\BiayaPendaftaran;
use Carbon\Carbon;

class ChatbotController extends Controller
{
    private $openaiApiKey;

    public function __construct()
    {
        $this->openaiApiKey = config('services.openai.api_key');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $request->input('message');

        try {
            // Ambil data terkini dari database
            $contextData = $this->getContextData();

            // Buat prompt dengan context data
            $systemPrompt = $this->buildSystemPrompt($contextData);

            // Kirim ke OpenAI
            // $response = Http::withHeaders([
            //     'Authorization' => 'Bearer ' . $this->openaiApiKey,
            //     'Content-Type' => 'application/json',
            // ])->post('https://api.openai.com/v1/chat/completions', [
            //     'model' => 'gpt-3.5-turbo',
            //     'messages' => [
            //         [
            //             'role' => 'system',
            //             'content' => $systemPrompt
            //         ],
            //         [
            //             'role' => 'user',
            //             'content' => $userMessage
            //         ]
            //     ],
            //     'max_tokens' => 500,
            //     'temperature' => 0.7,
            // ]);

            // tester openrouter
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->openaiApiKey,
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-chat-v3-0324:free',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ],
            ]);

            // if ($response->successful()) {
            $result = $response->json();
            $botReply = $result['choices'][0]['message']['content'];

            return response()->json([
                'success' => true,
                'message' => $botReply
            ])->setStatusCode(200);
            // } else {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Maaf, terjadi kesalahan pada sistem. Silakan coba lagi nanti.'
            //     ], 500);
            // }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan pada sistem. Silakan coba lagi nanti.'
            ], 500);
        }
    }

    private function getContextData()
    {
        // Ambil tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('status_aktif', true)->first();

        $data = [
            'tahun_ajaran' => null,
            'jadwal_ppdb' => [],
            'jalur_pendaftaran' => [],
            'biaya_pendaftaran' => []
        ];

        if ($tahunAjaranAktif) {
            $data['tahun_ajaran'] = [
                'nama' => $tahunAjaranAktif->nama_tahun_ajaran,
                'tanggal_mulai' => $tahunAjaranAktif->tanggal_mulai,
                'tanggal_selesai' => $tahunAjaranAktif->tanggal_selesai
            ];

            // Ambil jadwal PPDB
            $jadwalPpdb = JadwalPpdb::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->orderBy('tanggal_mulai')
                ->get();

            foreach ($jadwalPpdb as $jadwal) {
                $data['jadwal_ppdb'][] = [
                    'nama' => $jadwal->nama_jadwal,
                    'tanggal_mulai' => $jadwal->tanggal_mulai,
                    'tanggal_selesai' => $jadwal->tanggal_selesai,
                    'keterangan' => $jadwal->keterangan,
                    'status' => $this->getJadwalStatus($jadwal)
                ];
            }

            // Ambil biaya pendaftaran
            $biayaPendaftaran = BiayaPendaftaran::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();

            foreach ($biayaPendaftaran as $biaya) {
                $data['biaya_pendaftaran'][] = [
                    'jenis' => $biaya->jenis_biaya,
                    'jumlah' => $biaya->jumlah,
                    'mata_uang' => $biaya->mata_uang,
                    'wajib_bayar' => $biaya->wajib_bayar,
                    'keterangan' => $biaya->keterangan
                ];
            }
        }

        // Ambil jalur pendaftaran yang aktif
        $jalurPendaftaran = JalurPendaftaran::where('aktif', true)->get();

        foreach ($jalurPendaftaran as $jalur) {
            $data['jalur_pendaftaran'][] = [
                'nama' => $jalur->nama_jalur,
                'deskripsi' => $jalur->deskripsi
            ];
        }

        return $data;
    }

    private function getJadwalStatus($jadwal)
    {
        $today = Carbon::now()->toDateString();
        $mulai = $jadwal->tanggal_mulai;
        $selesai = $jadwal->tanggal_selesai;

        if ($today < $mulai) {
            return 'belum_dimulai';
        } elseif ($today >= $mulai && $today <= $selesai) {
            return 'sedang_berlangsung';
        } else {
            return 'sudah_selesai';
        }
    }

    private function buildSystemPrompt($contextData)
    {
        $prompt = "Anda adalah asisten virtual untuk PPDB (Penerimaan Peserta Didik Baru) SMP Harapan Bangsa. ";
        $prompt .= "Jawab pertanyaan dengan ramah, informatif, dan sesuai dengan data yang tersedia. ";
        $prompt .= "Gunakan bahasa Indonesia yang formal namun tetap bersahabat.\n\n";

        $prompt .= "INFORMASI TERKINI:\n\n";

        // Tahun Ajaran
        if ($contextData['tahun_ajaran']) {
            $prompt .= "TAHUN AJARAN:\n";
            $prompt .= "- Tahun Ajaran: " . $contextData['tahun_ajaran']['nama'] . "\n";
            $prompt .= "- Periode: " . Carbon::parse($contextData['tahun_ajaran']['tanggal_mulai'])->format('d M Y') . " - " . Carbon::parse($contextData['tahun_ajaran']['tanggal_selesai'])->format('d M Y') . "\n\n";
        }

        // Jadwal PPDB
        if (!empty($contextData['jadwal_ppdb'])) {
            $prompt .= "JADWAL PPDB:\n";
            foreach ($contextData['jadwal_ppdb'] as $jadwal) {
                $status = '';
                switch ($jadwal['status']) {
                    case 'belum_dimulai':
                        $status = ' (Belum Dimulai)';
                        break;
                    case 'sedang_berlangsung':
                        $status = ' (Sedang Berlangsung)';
                        break;
                    case 'sudah_selesai':
                        $status = ' (Sudah Selesai)';
                        break;
                }

                $prompt .= "- " . $jadwal['nama'] . ": " . Carbon::parse($jadwal['tanggal_mulai'])->format('d M Y') . " - " . Carbon::parse($jadwal['tanggal_selesai'])->format('d M Y') . $status . "\n";
                if ($jadwal['keterangan']) {
                    $prompt .= "  Keterangan: " . $jadwal['keterangan'] . "\n";
                }
            }
            $prompt .= "\n";
        }

        // Jalur Pendaftaran
        if (!empty($contextData['jalur_pendaftaran'])) {
            $prompt .= "JALUR PENDAFTARAN:\n";
            foreach ($contextData['jalur_pendaftaran'] as $jalur) {
                $prompt .= "- " . $jalur['nama'] . ": " . $jalur['deskripsi'] . "\n";
            }
            $prompt .= "\n";
        }

        // Biaya Pendaftaran
        if (!empty($contextData['biaya_pendaftaran'])) {
            $prompt .= "BIAYA PENDAFTARAN:\n";
            foreach ($contextData['biaya_pendaftaran'] as $biaya) {
                $prompt .= "- " . $biaya['jenis'] . ": Rp " . number_format($biaya['jumlah'], 0, ',', '.') . "\n";
                if ($biaya['keterangan']) {
                    $prompt .= "  Keterangan: " . $biaya['keterangan'] . "\n";
                }
            }
            $prompt .= "\n";
        }

        // Berkas yang diperlukan
        $prompt .= "BERKAS YANG DIPERLUKAN:\n";
        $prompt .= "- Ijazah atau Surat Keterangan Lulus (SKL)\n";
        $prompt .= "- Kartu Keluarga (KK)\n";
        $prompt .= "- Akta Kelahiran\n";
        $prompt .= "- Pas Foto terbaru\n\n";

        $prompt .= "PANDUAN MENJAWAB:\n";
        $prompt .= "- Jika ditanya tentang informasi yang tidak ada dalam data, jelaskan bahwa informasi tersebut perlu dikonfirmasi langsung ke sekolah\n";
        $prompt .= "- Berikan jawaban yang spesifik berdasarkan data yang tersedia\n";
        $prompt .= "- Jika ada jadwal yang sedang berlangsung, tekankan hal tersebut\n";
        $prompt .= "- Selalu akhiri dengan menanyakan apakah ada yang ingin ditanyakan lagi\n";
        $prompt .= "- Maksimal jawaban 300 kata";

        return $prompt;
    }
}
