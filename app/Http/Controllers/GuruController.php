<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.guru.index');
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
            $guru = Guru::create([
                'nip' => $request->nip,
                'biografi' => $request->biografi,
                'bidang_keahlian' => $request->bidang_keahlian,
            ]);

            $user = User::create([
                'guru_id' => $guru->id,
                'name' => $request->nama,
                'email' => $request->email,
                'username' => $request->nip,
                'password' => Hash::make($request->nip), // Default password is NIP
            ]);

            $user->assignRole('guru');


            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data guru berhasil ditambahkan'
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
    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return response()->json($guru);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $guru = Guru::findOrFail($id);
            $guru->update([
                'nip' => $request->nip,
                'biografi' => $request->biografi,
                'bidang_keahlian' => $request->bidang_keahlian,
            ]);

            $guru->user->update([
                'name' => $request->nama,
                'email' => $request->email,
                'username' => $request->nip,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data guru berhasil diperbarui'
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $guru = Guru::findOrFail($id);
            $guru->user->delete();
            $guru->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data guru berhasil dihapus'
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
        $guru = Guru::with('user')->select('guru.*');

        return DataTables::of($guru)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-sm btn-warning me-1 btn-edit" data-id="' . $row->id . '">
                            <i class="fas fa-edit"></i>
                        </button>';
                $btn .= '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function options()
    {
        $gurus = Guru::with('user')->get();

        return response()->json($gurus);
    }
}
