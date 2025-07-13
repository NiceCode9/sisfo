<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\GuruMataPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class GuruKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guruMataPelajaran = GuruMataPelajaran::with(['guru.user', 'mataPelajaran'])->get();
        $kelas = Kelas::all();
        $tahunAjaran = TahunAjaran::aktif()->first();

        // Data untuk filter
        $allTahunAjaran = TahunAjaran::all();
        $guru = Guru::with('user')->get();
        $mataPelajaran = MataPelajaran::all();

        return view('master.guru-kelas.index', compact(
            'guruMataPelajaran',
            'kelas',
            'tahunAjaran',
            'allTahunAjaran',
            'guru',
            'mataPelajaran'
        ));
    }

    public function datatable(Request $request)
    {
        $query = GuruKelas::with(['guruMataPelajaran.guru.user', 'guruMataPelajaran.mataPelajaran', 'kelas', 'tahunAjaran']);

        // Filter berdasarkan guru
        if ($request->has('guru_id') && $request->guru_id != '') {
            $query->whereHas('guruMataPelajaran', function ($q) use ($request) {
                $q->where('guru_id', $request->guru_id);
            });
        }

        // Filter berdasarkan kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->has('tahun_ajaran_id') && $request->tahun_ajaran_id != '') {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        // Filter berdasarkan mata pelajaran
        if ($request->has('mata_pelajaran_id') && $request->mata_pelajaran_id != '') {
            $query->whereHas('guruMataPelajaran', function ($q) use ($request) {
                $q->where('mata_pelajaran_id', $request->mata_pelajaran_id);
            });
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('aktif', $request->status);
        }

        $data = $query->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('guru', function ($row) {
                return $row->guruMataPelajaran->guru->user->name;
            })
            ->addColumn('mata_pelajaran', function ($row) {
                return $row->guruMataPelajaran->mataPelajaran->nama_pelajaran;
            })
            ->addColumn('kelas', function ($row) {
                return $row->kelas->nama_kelas;
            })
            ->addColumn('tahun_ajaran', function ($row) {
                return $row->tahunAjaran->nama_tahun_ajaran;
            })
            ->addColumn('status', function ($row) {
                return $row->aktif ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-sm btn-warning me-1 btn-edit" data-id="' . $row->id . '">Edit</button>';
                $btn .= '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guru_mata_pelajaran_id' => 'required|exists:guru_mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'aktif' => 'required|boolean',
            'keterangan' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Cek duplikasi
            $exists = GuruKelas::where('guru_mata_pelajaran_id', $request->guru_mata_pelajaran_id)
                ->where('kelas_id', $request->kelas_id)
                ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guru sudah mengajar di kelas ini pada tahun ajaran yang sama'
                ], 422);
            }

            GuruKelas::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan'
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
    public function show(string $id)
    {
        $guruKelas = GuruKelas::findOrFail($id);
        return response()->json($guruKelas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'guru_mata_pelajaran_id' => 'required|exists:guru_mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'aktif' => 'required|boolean',
            'keterangan' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $guruKelas = GuruKelas::findOrFail($id);

            // Cek duplikasi kecuali untuk data yang sedang diupdate
            $exists = GuruKelas::where('guru_mata_pelajaran_id', $request->guru_mata_pelajaran_id)
                ->where('kelas_id', $request->kelas_id)
                ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guru sudah mengajar di kelas ini pada tahun ajaran yang sama'
                ], 422);
            }

            $guruKelas->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui'
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
    public function destroy(string $id)
    {
        try {
            $guruKelas = GuruKelas::findOrFail($id);
            $guruKelas->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
