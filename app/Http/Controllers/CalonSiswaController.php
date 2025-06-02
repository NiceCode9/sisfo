<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalonSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahunAjaran = TahunAjaran::orderBy('nama_tahun_ajaran', 'desc')->get();
        $tahunAjaranId = $request->tahun_ajaran_id ?? TahunAjaran::where('status_aktif', true)->first()->id;

        $query = CalonSiswa::with('berkasCalonSiswa')
            ->where('tahun_ajaran_id', $tahunAjaranId);

        // Filter berdasarkan status
        if ($request->status && in_array($request->status, ['menunggu', 'diterima', 'ditolak'])) {
            $query->where('status_pendaftaran', $request->status);
        }

        // Pencarian berdasarkan nama, nik, atau nisn
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%");
            });
        }

        $calonSiswa = $query->get();

        return view('pendaftaran.index', compact('calonSiswa', 'tahunAjaran', 'tahunAjaranId'));
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
        $calonSiswa = CalonSiswa::with([
            'berkasCalonSiswa',
            'jalurPendaftaran',
            'tahunAjaran',
            'tahunAjaran.biayaPendaftaran',
            'pembayaran.biayaPendaftaran',
        ])->findOrFail($id);
        return view('pendaftaran.show', compact('calonSiswa'));
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
            $jalurPendaftaran = $calonSiswa->jalurPendaftaran;
            $jalurPendaftaran->load('kuotaPendaftaran');
            $jalurPendaftaran->kuotaPendaftaran->update([
                'terisi' => $jalurPendaftaran->kuotaPendaftaran->terisi + 1,
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

            DB::commit();

            return redirect()->route('admin.calon-siswa.show', $id)
                ->with('success', 'Status pendaftaran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
