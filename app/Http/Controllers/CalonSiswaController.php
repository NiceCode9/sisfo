<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Kelas;
use App\Models\RiwayatKelas;
use App\Models\TahunAjaran;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CalonSiswaController extends Controller
{
    private $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahunAjaran = TahunAjaran::orderBy('nama_tahun_ajaran', 'desc')->get();
        $tahunAjaranId = $request->tahun_ajaran_id ?? TahunAjaran::where('status_aktif', true)->first()->id;

        if ($request->ajax()) {
            $query = CalonSiswa::with('berkasCalonSiswa')
                ->where('tahun_ajaran_id', $tahunAjaranId);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('calon-siswa.show', $row->id) . '" class="btn btn-primary btn-sm">Detail</a>';
                })
                ->addColumn('status_badge', function ($row) {
                    switch ($row->status_pendaftaran) {
                        case 'menunggu':
                            return '<span class="badge bg-warning">Menunggu</span>';
                        case 'diterima':
                            return '<span class="badge bg-success">Diterima</span>';
                        case 'ditolak':
                            return '<span class="badge bg-danger">Ditolak</span>';
                        case 'perlu_perbaikan':
                            return '<span class="badge bg-info text-dark">Perlu Perbaikan</span>';
                        default:
                            return '<span class="badge bg-secondary">Unknown</span>';
                    }
                })
                ->addColumn('ttl', function ($row) {
                    return $row->tempat_lahir . ', ' . \Carbon\Carbon::parse($row->tanggal_lahir)->format('d/m/Y');
                })
                ->filter(function ($query) use ($request) {
                    // Filter berdasarkan status
                    if ($request->has('status_filter') && $request->status_filter != '') {
                        $query->where('status_pendaftaran', $request->status_filter);
                    }

                    // Global search
                    if ($request->has('search') && $request->search['value'] != '') {
                        $search = $request->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('nama_lengkap', 'like', "%{$search}%")
                                ->orWhere('nik', 'like', "%{$search}%")
                                ->orWhere('nisn', 'like', "%{$search}%")
                                ->orWhere('no_pendaftaran', 'like', "%{$search}%");
                        });
                    }
                })
                ->rawColumns(['action', 'status_badge'])
                ->make(true);
        }

        return view('pendaftaran.index', compact('tahunAjaran', 'tahunAjaranId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'jalur_pendaftaran_id' => 'required|exists:jalur_pendaftaran,id',
                'nik' => 'required|string|max:16|unique:calon_siswa,nik',
                'nisn' => 'required|string|max:10|unique:calon_siswa,nisn',
                'nama_lengkap' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'agama' => 'required|string|max:255',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'email' => 'required|email|unique:calon_siswa,email',
                'asal_sekolah' => 'required|string|max:255',
                'nama_ayah' => 'required|string|max:255',
                'pekerjaan_ayah' => 'required|string|max:255',
                'nama_ibu' => 'required|string|max:255',
                'pekerjaan_ibu' => 'required|string|max:255',
                'no_hp_orang_tua' => 'required|string|max:15',
                'foto_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'ijazah_path' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
                'kk_path' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
                'akta_path' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
                'skl_path' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
                'catatan_berkas' => 'nullable|string|max:255'
            ]);

            // Format tanggal_lahir ke Y-m-d
            $validated['tanggal_lahir'] = date('Y-m-d', strtotime($validated['tanggal_lahir']));

            // Simpan file upload
            $fotoPath = $request->file('foto_path') ? $request->file('foto_path')->store('berkas/foto', 'public') : null;
            $ijazahPath = $request->file('ijazah_path') ? $request->file('ijazah_path')->store('berkas/ijazah', 'public') : null;
            $kkPath = $request->file('kk_path') ? $request->file('kk_path')->store('berkas/kk', 'public') : null;
            $aktaPath = $request->file('akta_path') ? $request->file('akta_path')->store('berkas/akta', 'public') : null;
            $sklPath = $request->file('skl_path') ? $request->file('skl_path')->store('berkas/skl', 'public') : null;

            // Generate nomor pendaftaran
            $noPendaftaran = 'PPDB-' . date('Y') . '-' . str_pad(CalonSiswa::count() + 1, 4, '0', STR_PAD_LEFT);

            // Simpan data calon siswa
            $calonSiswa = CalonSiswa::create([
                'no_pendaftaran' => $noPendaftaran,
                'tahun_ajaran_id' => TahunAjaran::where('status_aktif', true)->first()->id,
                ...$validated,
                'status_pendaftaran' => 'menunggu'
            ]);

            // Simpan data berkas
            $calonSiswa->berkasCalonSiswa()->create([
                'ijazah_path' => $ijazahPath,
                'kk_path' => $kkPath,
                'akta_path' => $aktaPath,
                'foto_path' => $fotoPath,
                'skl_path' => $sklPath,
            ]);

            // Log Calon Siswa
            $calonSiswa->logStatusPendaftaran()->create([
                'status_baru' => 'menunggu',
                'catatan' => 'Pendaftaran baru',
            ]);

            DB::commit();

            return redirect()->route('pendaftaran')
                ->with('success', 'Pendaftaran berhasil! Nomor pendaftaran Anda: ' . $noPendaftaran);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kelas = Kelas::orderBy('tingkat', 'asc')->get();
        $calonSiswa = CalonSiswa::with([
            'berkasCalonSiswa',
            'jalurPendaftaran',
            'tahunAjaran',
            'tahunAjaran.biayaPendaftaran',
            'pembayaran.biayaPendaftaran',
        ])->findOrFail($id);
        return view('pendaftaran.show', compact('calonSiswa', 'kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalonSiswa $calonSiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CalonSiswa $calonSiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalonSiswa $calonSiswa)
    {
        //
    }

    /**
     * Update registration status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $calonSiswa = CalonSiswa::findOrFail($id);
            $validated = $request->validate([
                'status_pendaftaran' => 'required|in:diterima,ditolak,perlu_perbaikan',
                'catatan' => 'required_if:status_pendaftaran,ditolak,perlu_perbaikan',
                'berkas_perlu_perbaikan' => 'nullable|array', // Daftar field yang perlu diperbaiki
                'berkas_perlu_perbaikan.*' => 'in:ijazah_path,kk_path,akta_path,foto_path,skl_path'
            ]);

            if ($request->status_pendaftaran === 'ditolak' || $request->status_pendaftaran === 'perlu_perbaikan') {
                $calonSiswa->berkasCalonSiswa->update([
                    'alasan_penolakan' => $request->catatan,
                    'berkas_perlu_perbaikan' => $request->berkas_select ?? []
                ]);
            }

            if ($request->status_pendaftaran === 'diterima') {
                $jalurPendaftaran = $calonSiswa->jalurPendaftaran;
                $jalurPendaftaran->load('kuotaPendaftaran');
                $jalurPendaftaran->kuotaPendaftaran->update([
                    'terisi' => $jalurPendaftaran->kuotaPendaftaran->terisi + 1,
                ]);

                $siswa = $calonSiswa->siswa()->create([
                    'tahun_ajaran_id' => $calonSiswa->tahun_ajaran_id,
                    'nis' => $calonSiswa->nisn,
                    'nisn' => $calonSiswa->nisn,
                    'kelas_awal' => $request->kelas_id,
                ]);

                $siswa_account = $siswa->user()->create([
                    'name' => $calonSiswa->nama_lengkap,
                    'username' => $calonSiswa->nisn,
                    'email' => $calonSiswa->email,
                    'password' => bcrypt('password'),
                    'slug' => Str::slug($calonSiswa->nama_lengkap . '-' . $calonSiswa->nisn),
                ]);

                $siswa_account->assignRole('siswa');

                RiwayatKelas::create([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $request->kelas_id,
                    'tahun_ajaran_id' => $calonSiswa->tahun_ajaran_id,
                    'status' => 'aktif',
                    'keterangan' => 'Siswa baru diterima',
                ]);

                $calonSiswa->logStatusPendaftaran()->create([
                    'status_sebelumnya' => $calonSiswa->status_pendaftaran,
                    'status_baru' => $request->status_pendaftaran,
                    'catatan' => $request->catatan ?? null,
                    'user_id' => auth()->id(),
                ]);

                $validated = $request->validate([
                    'status_pendaftaran' => 'required|in:diterima,ditolak',
                    'catatan' => 'nullable|string|max:255',
                ]);

                $calonSiswa->update([
                    'status_pendaftaran' => $validated['status_pendaftaran']
                ]);
            }

            $calonSiswa->logStatusPendaftaran()->create([
                'status_sebelumnya' => $calonSiswa->status_pendaftaran,
                'status_baru' => $validated['status_pendaftaran'],
                'catatan' => $validated['catatan'] ?? null,
                'user_id' => auth()->id(),
            ]);

            $calonSiswa->update([
                'status_pendaftaran' => $validated['status_pendaftaran']
            ]);

            $pesan = "SMP PIRI NGAGLIK\n\n";
            $pesan .= "Status pendaftaran Anda telah diperbarui menjadi: " . strtoupper(str_replace('_', ' ', $validated['status_pendaftaran'])) . "\n";

            if ($validated['status_pendaftaran'] === 'perlu_perbaikan') {
                $berkasPerluPerbaikan = $calonSiswa->berkasCalonSiswa->berkas_perlu_perbaikan ?? [];
                if (!empty($berkasPerluPerbaikan)) {
                    $pesan .= "Silakan unggah ulang berkas berikut:\n";
                    foreach ($berkasPerluPerbaikan as $berkas) {
                        $pesan .= "- " . str_replace('_', ' ', pathinfo($berkas, PATHINFO_FILENAME)) . "\n";
                    }
                }
            }

            $pesan .= "\nTerima kasih telah mendaftar di SMP PIRI NGAGLIK.";

            $target = $this->whatsAppService->formatPhoneNumber('081328006147');
            $this->whatsAppService->sendMessage($target, $pesan);

            DB::commit();

            return redirect()->route('calon-siswa.show', $id)
                ->with('success', 'Status pendaftaran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function uploadUlang(Request $request, $id)
    {
        $request->validate([
            'berkas_type' => 'required|in:ijazah_path,kk_path,akta_path,foto_path,skl_path',
            'berkas_file' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120'
        ]);

        $calonSiswa = CalonSiswa::findOrFail($id);

        if ($calonSiswa->status_pendaftaran !== 'perlu_perbaikan') {
            return back()->withErrors(['error' => 'Tidak bisa mengunggah ulang berkas saat ini']);
        }

        // Simpan file
        $path = $request->file('berkas_file')->store(
            'berkas/' . $request->berkas_type,
            'public'
        );

        // Update path berkas
        $calonSiswa->berkasCalonSiswa->update([
            $request->berkas_type => $path
        ]);

        // Hapus dari daftar perlu perbaikan jika ada
        $berkasPerluPerbaikan = $calonSiswa->berkasCalonSiswa->berkas_perlu_perbaikan;
        if (($key = array_search($request->berkas_type, $berkasPerluPerbaikan)) !== false) {
            unset($berkasPerluPerbaikan[$key]);
            $calonSiswa->berkasCalonSiswa->update([
                'berkas_perlu_perbaikan' => array_values($berkasPerluPerbaikan)
            ]);
        }

        return back()->with('success', 'Berkas berhasil diunggah ulang');
    }
}
