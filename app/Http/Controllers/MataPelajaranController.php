<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.mata-pelajaran.index');
    }

    public function datatable()
    {
        $mataPelajaran = MataPelajaran::query();

        return DataTables::of($mataPelajaran)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                    <button type="button" class="btn btn-sm btn-warning me-1 btn-edit" data-id="' . $row->id . '"
                        data-nama="' . $row->nama_pelajaran . '"
                        data-kode="' . $row->kode_pelajaran . '"
                        data-deskripsi="' . $row->deskripsi . '">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="' . route('admin.mata-pelajaran.destroy', $row->id) . '" method="POST" class="d-inline"
                        data-mata-pelajaran-name="' . $row->nama_pelajaran . '">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                ';
                return $btn;
            })
            ->rawColumns(['action'])
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
            'nama_pelajaran' => 'required|string|max:255',
            'kode_pelajaran' => 'required|string|max:50|unique:mata_pelajaran,kode_pelajaran',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            MataPelajaran::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Mata pelajaran berhasil ditambahkan'
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
    public function show(MataPelajaran $mataPelajaran)
    {
        return response()->json($mataPelajaran);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
            'kode_pelajaran' => 'required|string|max:50|unique:mata_pelajaran,kode_pelajaran,' . $mataPelajaran->id,
            'deskripsi' => 'nullable|string'
        ]);

        try {
            $mataPelajaran->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Mata pelajaran berhasil diperbarui'
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
    public function destroy(MataPelajaran $mataPelajaran)
    {
        try {
            $mataPelajaran->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Mata pelajaran berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function options()
    {
        $mataPelajaran = MataPelajaran::select('id', 'nama_pelajaran', 'kode_pelajaran')->get();
        return response()->json($mataPelajaran);
    }
}
