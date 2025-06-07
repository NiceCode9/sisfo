<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\GuruMataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
    public function show(Tugas $tugas)
    {
        $tugas->load(['soal.jawaban', 'pengumpulanTugas']);
        return view('admin.tugas.show', compact('tugas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tugas $tugas)
    {
        $guruMapel = GuruMataPelajaran::with('mataPelajaran')
            ->where('guru_id', auth()->user()->guru->id)
            ->get();

        return view('admin.tugas.edit', compact('tugas', 'guruMapel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tugas)
    {
        $validator = Validator::make($request->all(), [
            'guru_mata_pelajaran_id' => 'required|exists:guru_mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'batas_waktu' => 'required|date',
            'total_nilai' => 'required|integer|min:0|max:100',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('file_tugas')) {
            // Hapus file lama jika ada
            if ($tugas->file_tugas) {
                Storage::disk('public')->delete($tugas->file_tugas);
            }
            $file = $request->file('file_tugas');
            $path = $file->store('tugas', 'public');
            $tugas->file_tugas = $path;
        }

        $tugas->update($request->except('file_tugas'));

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tugas $tugas)
    {
        if ($tugas->file_tugas) {
            Storage::disk('public')->delete($tugas->file_tugas);
        }

        $tugas->delete();

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
