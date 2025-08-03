<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\PendaftaranEkskul;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EkstrakurikulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ekstrakurikulers = Ekstrakurikuler::latest()->get();
        return view('master.ekstrakurikuler.index', compact('ekstrakurikulers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['success' => true]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_ekskul' => 'required|string|max:255|unique:ekstrakurikulers,nama_ekskul',
            'deskripsi' => 'required|string',
            'status' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            $data['slug'] = Str::slug($request->nama_ekskul);

            // Handle file upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('ekstrakurikuler', $filename, 'public');
                $data['foto'] = $path;
            }

            $ekstrakurikuler = Ekstrakurikuler::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Data ekstrakurikuler berhasil ditambahkan!',
                'data' => $ekstrakurikuler
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ekstrakurikuler $ekstrakurikuler)
    {
        return response()->json([
            'success' => true,
            'data' => $ekstrakurikuler
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        return response()->json([
            'success' => true,
            'data' => $ekstrakurikuler
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $validator = Validator::make($request->all(), [
            'nama_ekskul' => 'required|string|max:255|unique:ekstrakurikulers,nama_ekskul,' . $ekstrakurikuler->id,
            'deskripsi' => 'required|string',
            'status' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            $data['slug'] = Str::slug($request->nama_ekskul);

            // Handle file upload
            if ($request->hasFile('foto')) {
                // Delete old file if exists
                if ($ekstrakurikuler->foto && Storage::disk('public')->exists($ekstrakurikuler->foto)) {
                    Storage::disk('public')->delete($ekstrakurikuler->foto);
                }

                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('ekstrakurikuler', $filename, 'public');
                $data['foto'] = $path;
            }

            $ekstrakurikuler->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data ekstrakurikuler berhasil diupdate!',
                'data' => $ekstrakurikuler->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        try {
            // Delete file if exists
            if ($ekstrakurikuler->foto && Storage::disk('public')->exists($ekstrakurikuler->foto)) {
                Storage::disk('public')->delete($ekstrakurikuler->foto);
            }

            $ekstrakurikuler->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data ekstrakurikuler berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle pendaftaran ekstrakurikuler
     */
    public function daftar(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'siswa_id' => 'required|exists:siswas,id',
                'ekstrakurikuler_id' => 'required|exists:ekstrakurikulers,id',
                'catatan' => 'nullable|string|max:500'
            ], [
                'siswa_id.required' => 'Silakan pilih nama siswa',
                'siswa_id.exists' => 'Siswa yang dipilih tidak valid',
                'ekstrakurikuler_id.required' => 'Ekstrakurikuler tidak valid',
                'ekstrakurikuler_id.exists' => 'Ekstrakurikuler yang dipilih tidak tersedia',
                'catatan.max' => 'Catatan maksimal 500 karakter'
            ]);

            // Ambil tahun ajaran aktif
            $tahunAjaranAktif = TahunAjaran::aktif()->first();

            if (!$tahunAjaranAktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun ajaran aktif tidak ditemukan. Hubungi administrator.'
                ], 400);
            }

            // Cek apakah ekstrakurikuler masih aktif
            $ekstrakurikuler = Ekstrakurikuler::find($validated['ekstrakurikuler_id']);
            if (!$ekstrakurikuler->status) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ekstrakurikuler ini sedang tidak aktif untuk pendaftaran.'
                ], 400);
            }

            // Validasi: Cek apakah siswa sudah terdaftar di ekstrakurikuler yang sama
            $sudahTerdaftar = PendaftaranEkskul::where('siswa_id', $validated['siswa_id'])
                ->where('ekstrakurikuler_id', $validated['ekstrakurikuler_id'])
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->exists();

            if ($sudahTerdaftar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa sudah terdaftar di ekstrakurikuler ini untuk tahun ajaran yang sama.'
                ], 400);
            }

            // Ambil data siswa untuk respons
            $siswa = Siswa::find($validated['siswa_id']);

            // Simpan pendaftaran
            DB::transaction(function () use ($validated, $tahunAjaranAktif) {
                PendaftaranEkskul::create([
                    'siswa_id' => $validated['siswa_id'],
                    'ekstrakurikuler_id' => $validated['ekstrakurikuler_id'],
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'tanggal_daftar' => now(),
                    'catatan' => $validated['catatan']
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => "Pendaftaran berhasil! {$siswa->nama} telah terdaftar di {$ekstrakurikuler->nama_ekskul}."
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang dimasukkan tidak valid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error dalam pendaftaran ekstrakurikuler: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.'
            ], 500);
        }
    }
}
