<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $soals = Soal::with(['tugas', 'jawaban'])->paginate(10);
        return view('soal.index', compact('soals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tugas = Tugas::findOrFail($request->tugas);
        return view('soal.create', compact('tugas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tugas_id' => 'required|exists:tugas,id',
            'pertanyaan' => 'required|string',
            'jenis_soal' => 'required|in:uraian,pilihan_ganda',
            'poin' => 'required|integer|min:1',
            'urutan' => 'required|integer|min:1',
            'jawaban' => 'required_if:jenis_soal,pilihan_ganda|array',
            'jawaban.*.teks_jawaban' => 'required_if:jenis_soal,pilihan_ganda|string',
            'jawaban.*.jawaban_benar' => 'required_if:jenis_soal,pilihan_ganda|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $soal = Soal::create($request->only(['tugas_id', 'pertanyaan', 'jenis_soal', 'poin', 'urutan']));

        // Jika soal pilihan ganda, simpan jawaban
        if ($request->jenis_soal === 'pilihan_ganda' && !empty($request->jawaban)) {
            foreach ($request->jawaban as $jawaban) {
                $soal->jawaban()->create([
                    'teks_jawaban' => $jawaban['teks_jawaban'],
                    'jawaban_benar' => $jawaban['jawaban_benar'] ?? false
                ]);
            }
        }

        return redirect()->route('admin.soal.create', ['tugas' => $request->tugas_id])
            ->with('success', 'Soal berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Soal $soal)
    {
        $soal->load(['tugas', 'jawaban']);
        return view('soal.show', compact('soal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Soal $soal)
    {
        $soal->load(['tugas', 'jawaban']);
        return view('soal.edit', compact('soal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Soal $soal)
    {
        $validator = Validator::make($request->all(), [
            'pertanyaan' => 'required|string',
            'poin' => 'required|integer|min:1',
            'urutan' => 'required|integer|min:1',
            'jawaban' => 'required_if:jenis_soal,pilihan_ganda|array',
            'jawaban.*.teks_jawaban' => 'required_if:jenis_soal,pilihan_ganda|string',
            'jawaban.*.jawaban_benar' => 'required_if:jenis_soal,pilihan_ganda|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $soal->update($request->only(['pertanyaan', 'poin', 'urutan']));

        // Update jawaban jika soal pilihan ganda
        if ($soal->jenis_soal === 'pilihan_ganda' && !empty($request->jawaban)) {
            // Hapus jawaban lama
            $soal->jawaban()->delete();

            // Tambah jawaban baru
            foreach ($request->jawaban as $jawaban) {
                $soal->jawaban()->create([
                    'teks_jawaban' => $jawaban['teks_jawaban'],
                    'jawaban_benar' => $jawaban['jawaban_benar'] ?? false
                ]);
            }
        }

        return redirect()->route('admin.soal.show', $soal->id)
            ->with('success', 'Soal berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Soal $soal)
    {
        $tugasId = $soal->tugas_id;
        $soal->delete();

        return redirect()->route('admin.tugas.show', $tugasId)
            ->with('success', 'Soal berhasil dihapus');
    }
}
