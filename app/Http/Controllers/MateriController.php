<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\Materi;
use App\Models\GuruMataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $guruMataPelajaran = GuruMataPelajaran::with(['guru.user', 'mataPelajaran'])
        //     ->when(!Auth::user()->hasRole('superadmin'), function ($query) {
        //         return $query->whereHas('guru.user', function ($q) {
        //             $q->where('id', Auth::id());
        //         });
        //     })
        //     ->get();
        $guruKelas = GuruKelas::with(['guruMataPelajaran.mataPelajaran', 'guruMataPelajaran.guru.user'])
            ->when(!Auth::user()->hasRole('superadmin'), function ($query) {
                return $query->whereHas('guruMataPelajaran.guru.user', function ($q) {
                    $q->where('id', Auth::id());
                });
            })
            ->get();

        return view('e-learning.materi.index', compact('guruKelas'));
    }

    /**
     * Get data for DataTables
     */
    public function datatable()
    {
        $materi = Materi::with(['guruKelas.guruMataPelajaran.guru.user', 'guruKelas.guruMataPelajaran.mataPelajaran'])
            ->when(Auth::user()->hasRole('guru'), function ($query) {
                return $query->whereHas('guruKelas.guruMataPelajaran.guru.user', function ($q) {
                    $q->where('id', Auth::id());
                });
            })
            ->when(Auth::user()->hasRole('siswa'), function ($query) {
                return $query->whereHas('guruKelas', function ($q) {
                    $q->where('kelas_id', Auth::user()->siswa->kelasAktif()->kelas_id);
                });
            })
            ->get();
        return DataTables::of($materi)
            ->addIndexColumn()
            ->addColumn('guru', function ($row) {
                return $row->guruKelas->guruMataPelajaran->guru->user->name;
            })
            ->addColumn('mata_pelajaran', function ($row) {
                return $row->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran;
            })
            ->addColumn('file', function ($row) {
                return $row->path_file ? '<a href="' . route('materi.download', $row->id) . '" class="btn btn-sm btn-info">
                    <i class="fas fa-download"></i> Download</a>' : 'Tidak ada file';
            })
            ->addColumn('status', function ($row) {
                return $row->diterbitkan ?
                    '<span class="badge bg-success">Diterbitkan</span>' :
                    '<span class="badge bg-warning">Draft</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <button type="button" class="btn btn-sm btn-warning me-1 btn-edit" data-id="' . $row->id . '">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">
                        <i class="fas fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['file', 'status', 'action'])
            ->make(true);
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
        $request->validate([
            'guru_kelas_id' => 'required|exists:guru_kelas,id',
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx',
            'diterbitkan' => 'required|boolean'
        ]);

        try {
            // Check if user is authorized to upload for this guru_mata_pelajaran
            if (!Auth::user()->hasRole('superadmin')) {
                $guruKelas = GuruKelas::whereHas('guruMataPelajaran.guru.user', function ($query) {
                    $query->where('id', Auth::id());
                })->find($request->guru_kelas_id);

                if (!$guruKelas) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Anda tidak memiliki akses untuk mengunggah materi ini'
                    ], 403);
                }
            }

            if ($request->diterbitkan == '1') {
                $data['tanggal_terbit'] = now();
            }

            $data = $request->except('file');

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('materi', 'public');
                $data['path_file'] = $path;
            }

            Materi::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Materi berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Materi $materi)
    {
        // Check authorization
        if (!Auth::user()->hasRole('superadmin')) {
            $authorized = $materi->guruKelas->guruMataPelajaran->guru->user->id === Auth::id();
            if (!$authorized) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 403);
            }
        }

        $materi->load(['guruKelas.guruMataPelajaran.guru.user', 'guruKelas.guruMataPelajaran.mataPelajaran']);
        return response()->json($materi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        // Check authorization
        if (!Auth::user()->hasRole('superadmin')) {
            $authorized = $materi->guruKelas->guruMataPelajaran->guru->user->id === Auth::id();
            if (!$authorized) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 403);
            }
        }

        $request->validate([
            'guru_kelas_id' => 'required|exists:guru_kelas,id',
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx',
            'diterbitkan' => 'required|boolean'
        ]);

        try {
            $data = $request->except('file');

            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($materi->path_file) {
                    Storage::disk('public')->delete($materi->path_file);
                }

                $file = $request->file('file');
                $path = $file->store('materi', 'public');
                $data['path_file'] = $path;
            }

            $materi->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Materi berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi)
    {
        // Check authorization
        if (!Auth::user()->hasRole('superadmin')) {
            $authorized = $materi->guruKelas->guruMataPelajaran->guru->user->id === Auth::id();
            if (!$authorized) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 403);
            }
        }

        try {
            if ($materi->path_file) {
                Storage::disk('public')->delete($materi->path_file);
            }

            $materi->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Materi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download the material file.
     */
    public function download(Materi $materi)
    {
        // Check authorization
        if (!Auth::user()->hasRole('superadmin')) {
            $authorized = $materi->guruKelas->guruMataPelajaran->guru->user->id === Auth::id();
            if (!$authorized) {
                abort(403, 'Unauthorized');
            }
        }

        if (!$materi->path_file) {
            abort(404, 'File not found');
        }

        return response()->download(storage_path('app/public/' . $materi->path_file));
    }
}
