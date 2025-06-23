<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PengumpulanTugasController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('guru')) {
            $pengumpulan = PengumpulanTugas::whereHas('tugas.guruKelas.guruMataPelajaran.guru', function ($query) use ($user) {
                $query->whereHas('user', function ($q) use ($user) {
                    $q->where('id', $user->id);
                });
            })->with(['tugas', 'siswa'])->paginate(10);
        } else {
            $pengumpulan = PengumpulanTugas::where('siswa_id', $user->siswa->id)
                ->with(['tugas'])->paginate(10);
        }

        return view('pengumpulan-tugas.index', compact('pengumpulan'));
    }

    public function create(Request $request)
    {
        $tugas = Tugas::with(['soal.jawaban'])->findOrFail($request->tugas);

        // Cek apakah sudah melewati batas waktu
        if (now() > $tugas->batas_waktu) {
            return redirect()->back()->with('error', 'Batas waktu pengumpulan tugas telah berakhir');
        }

        // Cek apakah sudah pernah mengumpulkan
        $sudahMengumpulkan = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->where('siswa_id', Auth::user()->siswa->id)
            ->exists();

        if ($sudahMengumpulkan) {
            return redirect()->back()->with('error', 'Anda sudah mengumpulkan tugas ini');
        }

        return view('pengumpulan-tugas.create', compact('tugas'));
    }

    public function store(Request $request)
    {
        $tugas = Tugas::findOrFail($request->tugas_id);

        if ($tugas->metode_pengerjaan === 'upload_file') {
            $validator = Validator::make($request->all(), [
                'tugas_id' => 'required|exists:tugas,id',
                'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'teks_pengumpulan' => 'nullable|string'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'tugas_id' => 'required|exists:tugas,id',
                'jawaban' => 'required|array',
                'jawaban.*.soal_id' => 'required|exists:soal,id',
                'jawaban.*.jawaban_teks' => 'required_if:soal_jenis,uraian|string|nullable',
                'jawaban.*.id_jawaban' => 'required_if:soal_jenis,pilihan_ganda|exists:jawaban,id|nullable'
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat pengumpulan tugas
        $pengumpulan = PengumpulanTugas::create([
            'tugas_id' => $request->tugas_id,
            'siswa_id' => Auth::user()->siswa->id,
            'waktu_pengumpulan' => now(),
            'teks_pengumpulan' => $request->teks_pengumpulan
        ]);

        // $pengumpulan->hitungNilaiPilihanGanda();

        if ($tugas->metode_pengerjaan === 'upload_file') {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('pengumpulan-tugas', 'public');
                $pengumpulan->update(['path_file' => $path]);
            }
        } else {
            // Simpan jawaban siswa
            foreach ($request->jawaban as $jawaban) {
                JawabanSiswa::create([
                    'pengumpulan_id' => $pengumpulan->id,
                    'soal_id' => $jawaban['soal_id'],
                    'jawaban_teks' => $jawaban['jawaban_teks'] ?? null,
                    'id_jawaban' => $jawaban['id_jawaban'] ?? null
                ]);
            }
        }

        return redirect()->route('pengumpulan-tugas.index')
            ->with('success', 'Tugas berhasil dikumpulkan');
    }

    public function show(PengumpulanTugas $pengumpulanTuga)
    {
        $pengumpulanTuga->load(['tugas.soal.jawaban', 'jawabanSiswa', 'siswa']);
        return view('pengumpulan-tugas.show', compact('pengumpulanTuga'));
    }

    public function update(Request $request, PengumpulanTugas $pengumpulanTuga)
    {
        $validator = Validator::make($request->all(), [
            'nilai' => 'required|integer|min:0|max:100',
            'umpan_balik' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pengumpulanTuga->update($request->only(['nilai', 'umpan_balik']));

        return redirect()->route('pengumpulan-tugas.show', $pengumpulanTuga->id)
            ->with('success', 'Nilai dan umpan balik berhasil disimpan');
    }

    public function destroy(PengumpulanTugas $pengumpulanTuga)
    {
        if ($pengumpulanTuga->path_file) {
            Storage::disk('public')->delete($pengumpulanTuga->path_file);
        }

        $pengumpulanTuga->delete();

        return redirect()->route('pengumpulan-tugas.index')
            ->with('success', 'Pengumpulan tugas berhasil dihapus');
    }
}
