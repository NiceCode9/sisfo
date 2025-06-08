<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'tugas_id' => 'required|exists:tugas,id',
            'pertanyaan' => 'required|string|min:3',
            'jenis_soal' => 'required|in:uraian,pilihan_ganda',
            'poin' => 'required|integer|min:1|max:100',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('soal')->where(function ($query) use ($request) {
                    return $query->where('tugas_id', $request->tugas_id);
                })
            ],
            'jawaban' => 'required_if:jenis_soal,pilihan_ganda|array|min:2',
            'jawaban.*.teks_jawaban' => 'required_if:jenis_soal,pilihan_ganda|string|min:1',
            'jawaban.*.jawaban_benar' => 'required_if:jenis_soal,pilihan_ganda|boolean'
        ], [
            'pertanyaan.required' => 'Pertanyaan wajib diisi',
            'pertanyaan.min' => 'Pertanyaan minimal 3 karakter',
            'poin.min' => 'Poin minimal 1',
            'poin.max' => 'Poin maksimal 100',
            'urutan.unique' => 'Urutan soal sudah digunakan pada tugas ini',
            'jawaban.required_if' => 'Pilihan jawaban wajib diisi untuk soal pilihan ganda',
            'jawaban.min' => 'Minimal harus ada 2 pilihan jawaban',
            'jawaban.*.teks_jawaban.required_if' => 'Teks jawaban tidak boleh kosong',
            'jawaban.*.teks_jawaban.min' => 'Teks jawaban tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $soal = Soal::create($request->only(['tugas_id', 'pertanyaan', 'jenis_soal', 'poin', 'urutan']));

            // Jika soal pilihan ganda, simpan jawaban
            if ($request->jenis_soal === 'pilihan_ganda' && !empty($request->jawaban)) {
                // Validasi harus ada tepat satu jawaban benar
                $jawabanBenar = collect($request->jawaban)->where('jawaban_benar', true)->count();
                if ($jawabanBenar !== 1) {
                    throw new \Exception('Harus ada tepat satu jawaban yang benar');
                }

                foreach ($request->jawaban as $jawaban) {
                    $soal->jawaban()->create([
                        'teks_jawaban' => trim($jawaban['teks_jawaban']),
                        'jawaban_benar' => $jawaban['jawaban_benar'] ?? false
                    ]);
                }
            }

            DB::commit();

            if ($request->has('add_more')) {
                return redirect()->route('admin.soal.create', ['tugas' => $request->tugas_id])
                    ->with('success', 'Soal berhasil ditambahkan. Silahkan tambah soal lainnya.');
            }

            return redirect()->route('admin.tugas.show', $request->tugas_id)
                ->with('success', 'Soal berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
            'pertanyaan' => 'required|string|min:3',
            'poin' => 'required|integer|min:1|max:100',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('soal')->where(function ($query) use ($request, $soal) {
                    return $query->where('tugas_id', $soal->tugas_id)
                        ->where('id', '!=', $soal->id);
                })
            ],
            'jawaban' => 'required_if:jenis_soal,pilihan_ganda|array|min:2',
            'jawaban.*.teks_jawaban' => 'required_if:jenis_soal,pilihan_ganda|string|min:1',
            'jawaban.*.jawaban_benar' => 'required_if:jenis_soal,pilihan_ganda|boolean'
        ], [
            'pertanyaan.required' => 'Pertanyaan wajib diisi',
            'pertanyaan.min' => 'Pertanyaan minimal 3 karakter',
            'poin.min' => 'Poin minimal 1',
            'poin.max' => 'Poin maksimal 100',
            'urutan.unique' => 'Urutan soal sudah digunakan pada tugas ini',
            'jawaban.required_if' => 'Pilihan jawaban wajib diisi untuk soal pilihan ganda',
            'jawaban.min' => 'Minimal harus ada 2 pilihan jawaban',
            'jawaban.*.teks_jawaban.required_if' => 'Teks jawaban tidak boleh kosong',
            'jawaban.*.teks_jawaban.min' => 'Teks jawaban tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $soal->update($request->only(['pertanyaan', 'poin', 'urutan']));

            // Update jawaban jika soal pilihan ganda
            if ($soal->jenis_soal === 'pilihan_ganda' && !empty($request->jawaban)) {
                // Validasi harus ada tepat satu jawaban benar
                $jawabanBenar = collect($request->jawaban)->where('jawaban_benar', true)->count();
                if ($jawabanBenar !== 1) {
                    throw new \Exception('Harus ada tepat satu jawaban yang benar');
                }

                // Hapus jawaban lama
                $soal->jawaban()->delete();

                // Tambah jawaban baru
                foreach ($request->jawaban as $jawaban) {
                    $soal->jawaban()->create([
                        'teks_jawaban' => trim($jawaban['teks_jawaban']),
                        'jawaban_benar' => $jawaban['jawaban_benar'] ?? false
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.soal.show', $soal->id)
                ->with('success', 'Soal berhasil diperbarui');
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
    public function destroy(Soal $soal)
    {
        try {
            DB::beginTransaction();

            // Cek apakah soal sudah memiliki jawaban siswa
            if ($soal->jawabanSiswa()->exists()) {
                throw new \Exception('Soal tidak dapat dihapus karena sudah memiliki jawaban dari siswa');
            }

            $tugasId = $soal->tugas_id;

            // Hapus jawaban pilihan ganda jika ada
            $soal->jawaban()->delete();

            // Hapus soal
            $soal->delete();

            DB::commit();

            return redirect()->route('admin.tugas.show', $tugasId)
                ->with('success', 'Soal berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
