<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

            // Validasi input
            $request->validate([
                'nip' => 'required|string|max:20|unique:guru,nip',
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'biografi' => 'nullable|string',
                'bidang_keahlian' => 'required|string|max:255',
                'gelar' => 'required|string|max:50',
                'telp' => 'required|string|max:15',
                'foto_path' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
            ], [
                'nip.required' => 'NIP wajib diisi',
                'nip.unique' => 'NIP sudah terdaftar',
                'nama.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'bidang_keahlian.required' => 'Bidang keahlian wajib diisi',
                'gelar.required' => 'Gelar wajib diisi',
                'telp.required' => 'No. Telepon wajib diisi',
                'foto_path.image' => 'File harus berupa gambar',
                'foto_path.mimes' => 'Format gambar harus jpeg, png, atau jpg',
                'foto_path.max' => 'Ukuran gambar maksimal 2MB',
            ]);

            // Handle file upload
            $fotoPath = null;
            if ($request->hasFile('foto_path')) {
                $fotoPath = $request->file('foto_path')->store('guru_fotos', 'public');
            }

            $guru = Guru::create([
                'nip' => $request->nip,
                'biografi' => $request->biografi,
                'bidang_keahlian' => $request->bidang_keahlian,
                'gelar' => $request->gelar,
                'telp' => $request->telp,
                'foto_path' => $fotoPath,
            ]);

            $user = User::create([
                'guru_id' => $guru->id,
                'name' => $request->nama,
                'email' => $request->email,
                'username' => $request->nip ?: Str::random(8),
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

            // Validasi input
            $request->validate([
                'nip' => 'required|string|max:20|unique:guru,nip,' . $id,
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $guru->user->id,
                'biografi' => 'nullable|string',
                'bidang_keahlian' => 'required|string|max:255',
                'gelar' => 'required|string|max:50',
                'telp' => 'required|string|max:15',
                'foto_path' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
            ], [
                'nip.required' => 'NIP wajib diisi',
                'nip.unique' => 'NIP sudah terdaftar',
                'nama.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'bidang_keahlian.required' => 'Bidang keahlian wajib diisi',
                'gelar.required' => 'Gelar wajib diisi',
                'telp.required' => 'No. Telepon wajib diisi',
                'foto_path.image' => 'File harus berupa gambar',
                'foto_path.mimes' => 'Format gambar harus jpeg, png, atau jpg',
                'foto_path.max' => 'Ukuran gambar maksimal 2MB',
            ]);

            $data = [
                'nip' => $request->nip,
                'biografi' => $request->biografi,
                'bidang_keahlian' => $request->bidang_keahlian,
                'gelar' => $request->gelar,
                'telp' => $request->telp,
            ];

            // Handle file upload if new file is provided
            if ($request->hasFile('foto_path')) {
                // Delete old file if exists
                if ($guru->foto_path) {
                    Storage::disk('public')->delete($guru->foto_path);
                }
                $data['foto_path'] = $request->file('foto_path')->store('guru_fotos', 'public');
            }

            $guru->update($data);

            $guru->user->update([
                'name' => $request->nama,
                'email' => $request->email,
                'username' => $request->nip ?: Str::random(8),
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

            // Delete foto if exists
            if ($guru->foto_path) {
                Storage::disk('public')->delete($guru->foto_path);
            }

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
