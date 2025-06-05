<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\GuruMataPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::all();
        $guruMataPelajaran = GuruMataPelajaran::with(['guru.user', 'mataPelajaran'])->get();

        return view('master.jadwal.index', compact('kelas', 'guruMataPelajaran'));
    }

    /**
     * Get data for DataTables
     */
    public function datatable()
    {
        $jadwal = Jadwal::with(['guruMataPelajaran.guru.user', 'guruMataPelajaran.mataPelajaran', 'kelas'])->get();

        return DataTables::of($jadwal)
            ->addIndexColumn()
            ->addColumn('guru', function ($row) {
                return $row->guruMataPelajaran->guru->user->name;
            })
            ->addColumn('mata_pelajaran', function ($row) {
                return $row->guruMataPelajaran->mataPelajaran->nama_pelajaran;
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
            'guru_mata_pelajaran_id' => 'required|exists:guru_mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:50'
        ]);

        try {
            // Check for schedule conflicts
            $conflictingSchedule = Jadwal::where('hari', $request->hari)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
                })
                ->where(function ($query) use ($request) {
                    $query->where('kelas_id', $request->kelas_id)
                        ->orWhere('guru_mata_pelajaran_id', $request->guru_mata_pelajaran_id);
                })
                ->first();

            if ($conflictingSchedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal tersebut bertabrakan dengan jadwal yang sudah ada'
                ], 422);
            }

            Jadwal::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal pelajaran berhasil ditambahkan'
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
    public function show(Jadwal $jadwal)
    {
        $jadwal->load(['guruMataPelajaran.guru.user', 'guruMataPelajaran.mataPelajaran', 'kelas']);
        return response()->json($jadwal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'guru_mata_pelajaran_id' => 'required|exists:guru_mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:50'
        ]);

        try {
            // Check for schedule conflicts
            $conflictingSchedule = Jadwal::where('hari', $request->hari)
                ->where('id', '!=', $jadwal->id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
                })
                ->where(function ($query) use ($request) {
                    $query->where('kelas_id', $request->kelas_id)
                        ->orWhere('guru_mata_pelajaran_id', $request->guru_mata_pelajaran_id);
                })
                ->first();

            if ($conflictingSchedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal tersebut bertabrakan dengan jadwal yang sudah ada'
                ], 422);
            }

            $jadwal->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal pelajaran berhasil diperbarui'
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
    public function destroy(Jadwal $jadwal)
    {
        try {
            $jadwal->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal pelajaran berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
