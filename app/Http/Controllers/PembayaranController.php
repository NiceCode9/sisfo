<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\BiayaPendaftaran;
use App\Models\Pembayaran;
use App\Models\PembayaranLainnya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['calonSiswa', 'biayaPendaftaran']);

        // Filter berdasarkan rentang tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_pembayaran', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } elseif ($request->start_date) {
            $query->where('tanggal_pembayaran', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->end_date) {
            $query->where('tanggal_pembayaran', '<=', $request->end_date . ' 23:59:59');
        }

        // Pencarian berdasarkan kode pembayaran atau nama calon siswa
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_pembayaran', 'like', "%{$search}%")
                    ->orWhereHas('calonSiswa', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        }

        $pembayarans = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pembayaran.index', compact('pembayarans'));
    }

    public function store(Request $request, CalonSiswa $calonSiswa)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'biaya_pendaftaran_id' => 'required|exists:biaya_pendaftaran,id',
                'jumlah' => 'required|numeric|min:0',
                'metode_pembayaran' => 'required|in:transfer,tunai',
                'tanggal_pembayaran' => 'required|date',
                'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
                'catatan' => 'nullable|string|max:255'
            ]);

            $biayaPendaftaran = BiayaPendaftaran::findOrFail($validated['biaya_pendaftaran_id']);

            // Upload bukti pembayaran jika ada
            $buktiPembayaranPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('pembayaran/bukti', 'public');
            }

            // Generate kode pembayaran
            $kodePembayaran = 'PAY-' . date('YmdHis') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

            // Simpan pembayaran
            Pembayaran::create([
                'calon_siswa_id' => $calonSiswa->id,
                'biaya_pendaftaran_id' => $biayaPendaftaran->id,
                'kode_pembayaran' => $kodePembayaran,
                'jumlah' => $validated['jumlah'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'bukti_pembayaran_path' => $buktiPembayaranPath,
                'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                'status' => 'sukses',
                'catatan' => $validated['catatan']
            ]);

            DB::commit();

            return redirect()->route('admin.calon-siswa.show', $calonSiswa->id)
                ->with('success', 'Pembayaran berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang sudah diupload jika ada error
            if (isset($buktiPembayaranPath)) {
                Storage::disk('public')->delete($buktiPembayaranPath);
            }

            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan pembayaran: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with(['calonSiswa', 'biayaPendaftaran'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'html' => view('pembayaran.partials.detail-modal', compact('pembayaran'))->render()
        ]);
    }
}
