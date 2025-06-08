<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\GuruMataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tugas = Tugas::with('guruMataPelajaran.mataPelajaran')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tugas.index', compact('tugas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guruMapel = GuruMataPelajaran::with('mataPelajaran')
            ->where('guru_id', auth()->user()->guru->id)
            ->get();

        return view('tugas.create', compact('guruMapel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guru_mata_pelajaran_id' => 'required|exists:guru_mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'batas_waktu' => 'required|date',
            'total_nilai' => 'required|integer|min:0|max:100',
            'jenis' => 'required|in:uraian,pilihan_ganda,campuran',
            'metode_pengerjaan' => 'required|in:online,upload_file',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tugas = new Tugas($request->except('file_tugas'));

        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            $path = $file->store('tugas', 'public');
            $tugas->file_tugas = $path;
        }

        $tugas->save();

        if ($tugas->metode_pengerjaan === 'online') {
            return redirect()->route('admin.soal.create', ['tugas' => $tugas->id])
                ->with('success', 'Tugas berhasil dibuat, silahkan tambahkan soal.');
        }

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tuga)
    {
        $tuga->load(['soal.jawaban', 'pengumpulanTugas']);
        return view('tugas.show', compact('tuga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tugas $tuga)
    {
        $guruMapel = GuruMataPelajaran::with('mataPelajaran')
            ->where('guru_id', auth()->user()->guru->id)
            ->get();

        return view('tugas.edit', compact('tuga', 'guruMapel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tuga)
    {
        try {
            $rules = [
                'guru_mata_pelajaran_id' => 'required|exists:guru_mata_pelajaran,id',
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'batas_waktu' => 'required|date',
                'total_nilai' => 'required|integer|min:0|max:100',
            ];

            // Hanya validasi file jika tugas tipe upload file
            if ($tuga->metode_pengerjaan === 'upload_file') {
                $rules['file_tugas'] = 'nullable|file|mimes:pdf,doc,docx|max:2048';
            }

            $validator = Validator::make($request->all(), $rules, [
                'guru_mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih',
                'judul.required' => 'Judul tugas wajib diisi',
                'judul.max' => 'Judul tugas maksimal 255 karakter',
                'deskripsi.required' => 'Deskripsi tugas wajib diisi',
                'batas_waktu.required' => 'Batas waktu wajib diisi',
                'batas_waktu.date' => 'Format batas waktu tidak valid',
                'total_nilai.required' => 'Total nilai wajib diisi',
                'total_nilai.integer' => 'Total nilai harus berupa angka',
                'total_nilai.min' => 'Total nilai minimal 0',
                'total_nilai.max' => 'Total nilai maksimal 100',
                'file_tugas.mimes' => 'File tugas harus berformat PDF, DOC, atau DOCX',
                'file_tugas.max' => 'Ukuran file tugas maksimal 2MB'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();

            if ($request->hasFile('file_tugas')) {
                // Hapus file lama jika ada
                if ($tuga->file_tugas) {
                    Storage::disk('public')->delete($tuga->file_tugas);
                }
                $file = $request->file('file_tugas');
                $path = $file->store('tugas', 'public');
                $tuga->file_tugas = $path;
            }

            $tuga->update($request->except(['file_tugas', 'metode_pengerjaan', 'jenis']));

            DB::commit();

            return redirect()->route('admin.tugas.show', $tuga->id)
                ->with('success', 'Tugas berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tugas $tuga)
    {
        if ($tuga->file_tugas) {
            Storage::disk('public')->delete($tuga->file_tugas);
        }

        $tuga->delete();

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
