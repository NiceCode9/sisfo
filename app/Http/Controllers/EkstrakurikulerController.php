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
use Yajra\DataTables\Facades\DataTables;

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
     * Display the specified resource with detailed view.
     */
    public function show(Ekstrakurikuler $ekstrakurikuler)
    {
        // Get active academic year
        $tahunAjaranAktif = TahunAjaran::aktif()->first();

        // Count total members for this extracurricular (only active members)
        $totalAnggota = PendaftaranEkskul::where('ekstrakurikuler_id', $ekstrakurikuler->id)
            ->where('status', true) // Only count active members
            ->when($tahunAjaranAktif, function ($query) use ($tahunAjaranAktif) {
                return $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);
            })
            ->count();

        // Get all academic years for filter dropdown
        $tahunAjarans = TahunAjaran::orderBy('nama_tahun_ajaran', 'desc')->get();

        return view('master.ekstrakurikuler.show', compact('ekstrakurikuler', 'totalAnggota', 'tahunAjarans', 'tahunAjaranAktif'));
    }

    /**
     * Get members data for DataTables
     */
    public function getMembers(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $query = PendaftaranEkskul::with(['siswa.riwayatKelas', 'tahunAjaran'])
            ->where('ekstrakurikuler_id', $ekstrakurikuler->id);

        // Filter by academic year if provided
        if ($request->filled('tahun_ajaran_id') && $request->tahun_ajaran_id != 'all') {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nama_siswa', function ($row) {
                return $row->siswa->calonSiswa->nama_lengkap ?? '-';
            })
            ->addColumn('nis', function ($row) {
                return $row->siswa->nis ?? '-';
            })
            ->addColumn('kelas', function ($row) {
                $kelas = $row->siswa->riwayatKelas()->where('status', 'aktif')
                    ->where('tahun_ajaran_id', $row->tahunAjaran->id)
                    ->first();
                $namaKelas = $kelas ? $kelas->kelas->tingkat . '-' . $kelas->kelas->nama_kelas : '-';
                return $namaKelas;
            })
            ->addColumn('tahun_ajaran', function ($row) {
                return $row->tahunAjaran->nama_tahun_ajaran ?? '-';
            })
            ->addColumn('tanggal_daftar', function ($row) {
                return $row->tanggal_daftar ? \Carbon\Carbon::parse($row->tanggal_daftar)->format('d/m/Y') : '-';
            })
            ->addColumn('status', function ($row) {
                if ($row->status) {
                    return '<span class="badge bg-success">Aktif</span>';
                } else {
                    return '<span class="badge bg-secondary">Nonaktif</span>';
                }
            })
            ->addColumn('catatan', function ($row) {
                return $row->catatan ? Str::limit($row->catatan, 50) : '-';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<button type="button" class="btn btn-sm btn-info btn-detail" data-id="' . $row->id . '" title="Detail">';
                $btn .= '<i class="fas fa-eye"></i>';
                $btn .= '</button>';

                if (!auth()->user()->hasRole('siswa')) {
                    // Toggle status button
                    if ($row->status) {
                        $btn .= '<button type="button" class="btn btn-sm btn-warning btn-toggle-status" data-id="' . $row->id . '" data-name="' . ($row->siswa->calonSiswa->nama_lengkap ?? '') . '" data-status="nonaktif" title="Nonaktifkan Anggota">';
                        $btn .= '<i class="fas fa-toggle-off"></i>';
                        $btn .= '</button>';
                    } else {
                        $btn .= '<button type="button" class="btn btn-sm btn-success btn-toggle-status" data-id="' . $row->id . '" data-name="' . ($row->siswa->calonSiswa->nama_lengkap ?? '') . '" data-status="aktif" title="Aktifkan Anggota">';
                        $btn .= '<i class="fas fa-toggle-on"></i>';
                        $btn .= '</button>';
                    }
                }

                $btn .= '</div>';
                return $btn;
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->search['value'])) {
                    $searchValue = $request->search['value'];
                    $query->whereHas('siswa', function ($q) use ($searchValue) {
                        $q->where('nama', 'like', "%{$searchValue}%")
                            ->orWhere('nis', 'like', "%{$searchValue}%");
                    })
                        ->orWhereHas('siswa.kelasAktif', function ($q) use ($searchValue) {
                            $q->where('nama_kelas', 'like', "%{$searchValue}%");
                        })
                        ->orWhere('catatan', 'like', "%{$searchValue}%");
                }
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    /**
     * Get member detail
     */
    public function getMemberDetail($id)
    {
        try {
            $member = PendaftaranEkskul::with(['siswa.kelas', 'ekstrakurikuler', 'tahunAjaran'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $member
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Toggle member status (active/inactive) instead of removing
     */
    public function toggleMemberStatus($id)
    {
        try {
            $member = PendaftaranEkskul::with(['siswa.calonSiswa', 'ekstrakurikuler'])
                ->findOrFail($id);

            // Toggle status
            $newStatus = !$member->status;
            $member->update(['status' => $newStatus]);

            $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            $namaAnggota = $member->siswa->calonSiswa->nama_lengkap ?? 'Anggota';

            return response()->json([
                'success' => true,
                'message' => "{$namaAnggota} berhasil {$statusText} dari ekstrakurikuler {$member->ekstrakurikuler->nama_ekskul}",
                'new_status' => $newStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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
            $user = auth()->user();

            // Jika user adalah siswa, gunakan data siswa dari relasi user
            if ($user->hasRole('siswa')) {
                $siswa = $user->siswa; // Asumsi ada relasi user->siswa

                if (!$siswa) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data siswa tidak ditemukan. Hubungi administrator.'
                    ], 400);
                }

                $validated = $request->validate([
                    'ekstrakurikuler_id' => 'required|exists:ekstrakurikulers,id',
                    'catatan' => 'nullable|string|max:500'
                ], [
                    'ekstrakurikuler_id.required' => 'Ekstrakurikuler tidak valid',
                    'ekstrakurikuler_id.exists' => 'Ekstrakurikuler yang dipilih tidak tersedia',
                    'catatan.max' => 'Catatan maksimal 500 karakter'
                ]);

                $validated['siswa_id'] = $siswa->id;
            } else {
                // Jika user bukan siswa (admin/guru), validasi seperti biasa
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

                $siswa = Siswa::find($validated['siswa_id']);
            }

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
                    'message' => 'Anda sudah terdaftar di ekstrakurikuler ini untuk tahun ajaran yang sama.'
                ], 400);
            }

            // Simpan pendaftaran dengan status aktif
            DB::transaction(function () use ($validated, $tahunAjaranAktif) {
                PendaftaranEkskul::create([
                    'siswa_id' => $validated['siswa_id'],
                    'ekstrakurikuler_id' => $validated['ekstrakurikuler_id'],
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'tanggal_daftar' => now(),
                    'catatan' => $validated['catatan'],
                    'status' => true // Set status aktif by default
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => "Pendaftaran berhasil! Anda telah terdaftar di {$ekstrakurikuler->nama_ekskul}."
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

    /**
     * Check if current student is already registered
     */
    public function checkRegistration(Ekstrakurikuler $ekstrakurikuler)
    {
        try {
            $user = auth()->user();

            if (!$user->hasRole('siswa')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak'
                ], 403);
            }

            $siswa = $user->siswa;
            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data siswa tidak ditemukan'
                ], 400);
            }

            $tahunAjaranAktif = TahunAjaran::aktif()->first();

            $sudahTerdaftar = PendaftaranEkskul::where('siswa_id', $siswa->id)
                ->where('ekstrakurikuler_id', $ekstrakurikuler->id)
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->exists();

            return response()->json([
                'success' => true,
                'is_registered' => $sudahTerdaftar,
                'ekstrakurikuler_active' => $ekstrakurikuler->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }
}
