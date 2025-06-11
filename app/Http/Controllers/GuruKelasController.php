<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\GuruMataPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
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

        return view('master.guru-kelas.index', compact('guruMataPelajaran', 'kelas', 'tahunAjaran'));
    }

    public function datatable()
    {
        $data = GuruKelas::with(['guruMataPelajaran.guru.user', 'guruMataPelajaran.mataPelajaran', 'kelas', 'tahunAjaran'])
            ->get();

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
                return $row->aktif ? 'Aktif' : 'Tidak Aktif';
            })
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-sm btn-warning me-1 btn-edit" data-id="' . $row->id . '">Edit</button>';
                $btn .= '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action'])
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
