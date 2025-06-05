<?php

namespace App\Http\Controllers;

use App\Models\GuruMataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class GuruMataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.guru-mata-pelajaran.index');
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

            // Check if assignment already exists
            $exists = GuruMataPelajaran::where('guru_id', $request->guru_id)
                ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Guru sudah ditugaskan untuk mata pelajaran ini'
                ], 422);
            }

            GuruMataPelajaran::create([
                'guru_id' => $request->guru_id,
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Penugasan guru mata pelajaran berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GuruMataPelajaran $guruMataPelajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuruMataPelajaran $guruMataPelajaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuruMataPelajaran $guruMataPelajaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $assignment = GuruMataPelajaran::findOrFail($id);
            $assignment->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Penugasan guru mata pelajaran berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function datatable()
    {
        $assignments = GuruMataPelajaran::with(['guru.user', 'mataPelajaran']);

        return DataTables::of($assignments)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
