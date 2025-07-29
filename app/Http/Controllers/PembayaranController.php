<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\BiayaPendaftaran;
use App\Models\DetailAngsuran;
use App\Models\Pembayaran;
use App\Models\RencanaAngsuran;
use App\Models\PembayaranLainnya;
use Carbon\Carbon;
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

    // public function store(Request $request, CalonSiswa $calonSiswa)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $validated = $request->validate([
    //             'biaya_pendaftaran_id' => 'required|exists:biaya_pendaftaran,id',
    //             'jumlah' => 'required|numeric|min:0',
    //             'metode_pembayaran' => 'required|in:transfer,tunai',
    //             'tanggal_pembayaran' => 'required|date',
    //             'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
    //             'catatan' => 'nullable|string|max:255'
    //         ]);

    //         $biayaPendaftaran = BiayaPendaftaran::findOrFail($validated['biaya_pendaftaran_id']);

    //         // Upload bukti pembayaran jika ada
    //         $buktiPembayaranPath = null;
    //         if ($request->hasFile('bukti_pembayaran')) {
    //             $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('pembayaran/bukti', 'public');
    //         }

    //         // Generate kode pembayaran
    //         $kodePembayaran = 'PAY-' . date('YmdHis') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

    //         // Simpan pembayaran
    //         Pembayaran::create([
    //             'calon_siswa_id' => $calonSiswa->id,
    //             'biaya_pendaftaran_id' => $biayaPendaftaran->id,
    //             'kode_pembayaran' => $kodePembayaran,
    //             'jumlah' => $validated['jumlah'],
    //             'metode_pembayaran' => $validated['metode_pembayaran'],
    //             'bukti_pembayaran_path' => $buktiPembayaranPath,
    //             'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
    //             'status' => 'sukses',
    //             'catatan' => $validated['catatan']
    //         ]);

    //         DB::commit();

    //         return redirect()->route('calon-siswa.show', $calonSiswa->id)
    //             ->with('success', 'Pembayaran berhasil disimpan');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         // Hapus file yang sudah diupload jika ada error
    //         if (isset($buktiPembayaranPath)) {
    //             Storage::disk('public')->delete($buktiPembayaranPath);
    //         }

    //         return back()->withInput()
    //             ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan pembayaran: ' . $e->getMessage()]);
    //     }
    // }

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
                'catatan' => 'nullable|string|max:255',

                // Validasi tambahan untuk angsuran
                'jenis_pembayaran' => 'required|in:penuh,dp_angsuran,cicilan_angsuran',
                'detail_angsuran_id' => 'nullable|exists:detail_angsurans,id',

                // Untuk pembayaran angsuran baru (DP)
                'jumlah_cicilan' => 'nullable|integer|min:2|max:12',
                'tanggal_mulai_cicilan' => 'nullable|date|after:today',
            ]);

            $biayaPendaftaran = BiayaPendaftaran::findOrFail($validated['biaya_pendaftaran_id']);

            // Validasi khusus berdasarkan jenis pembayaran
            $this->validateJenisPembayaran($validated, $biayaPendaftaran, $calonSiswa);

            // Upload bukti pembayaran jika ada
            $buktiPembayaranPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('pembayaran/bukti', 'public');
            }

            // Generate kode pembayaran
            $kodePembayaran = 'PAY-' . date('YmdHis') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

            // Proses berdasarkan jenis pembayaran
            switch ($validated['jenis_pembayaran']) {
                case 'penuh':
                    $this->processPembayaranPenuh($validated, $calonSiswa, $biayaPendaftaran, $kodePembayaran, $buktiPembayaranPath);
                    break;

                case 'dp_angsuran':
                    $this->processPembayaranDP($validated, $calonSiswa, $biayaPendaftaran, $kodePembayaran, $buktiPembayaranPath);
                    break;

                case 'cicilan_angsuran':
                    $this->processPembayaranCicilan($validated, $calonSiswa, $biayaPendaftaran, $kodePembayaran, $buktiPembayaranPath);
                    break;
            }

            DB::commit();

            $message = $this->getSuccessMessage($validated['jenis_pembayaran']);
            return redirect()->route('calon-siswa.show', $calonSiswa->id)
                ->with('success', $message);
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

    private function validateJenisPembayaran($validated, $biayaPendaftaran, $calonSiswa)
    {
        switch ($validated['jenis_pembayaran']) {
            case 'penuh':
                // Validasi pembayaran penuh
                if ($validated['jumlah'] != $biayaPendaftaran->jumlah) {
                    throw new \Exception('Jumlah pembayaran harus sama dengan total biaya untuk pembayaran penuh');
                }
                break;

            case 'dp_angsuran':
                // Validasi DP angsuran
                if (!$biayaPendaftaran->dapat_diangsur) {
                    throw new \Exception('Biaya ini tidak dapat diangsur');
                }

                if ($validated['jumlah'] < $biayaPendaftaran->min_dp) {
                    throw new \Exception('Jumlah DP minimal Rp ' . number_format($biayaPendaftaran->min_dp, 0, ',', '.'));
                }

                if (!isset($validated['jumlah_cicilan']) || !isset($validated['tanggal_mulai_cicilan'])) {
                    throw new \Exception('Jumlah cicilan dan tanggal mulai cicilan harus diisi untuk pembayaran DP');
                }

                // Cek apakah sudah ada rencana angsuran untuk biaya ini
                $existingAngsuran = RencanaAngsuran::where('calon_siswa_id', $calonSiswa->id)
                    ->where('biaya_pendaftaran_id', $biayaPendaftaran->id)
                    ->where('status', '!=', 'batal')
                    ->first();

                if ($existingAngsuran) {
                    throw new \Exception('Sudah ada rencana angsuran aktif untuk biaya ini');
                }
                break;

            case 'cicilan_angsuran':
                // Validasi pembayaran cicilan
                if (!isset($validated['detail_angsuran_id'])) {
                    throw new \Exception('Detail angsuran harus dipilih untuk pembayaran cicilan');
                }

                $detailAngsuran = DetailAngsuran::findOrFail($validated['detail_angsuran_id']);

                if ($detailAngsuran->status == 'dibayar') {
                    throw new \Exception('Cicilan ini sudah dibayar');
                }

                // Hitung total yang harus dibayar (nominal + denda jika ada)
                $totalYangHarusDibayar = $detailAngsuran->nominal_cicilan + $detailAngsuran->denda;

                if ($validated['jumlah'] < $totalYangHarusDibayar) {
                    throw new \Exception('Jumlah pembayaran kurang. Total yang harus dibayar: Rp ' . number_format($totalYangHarusDibayar, 0, ',', '.'));
                }
                break;
        }
    }

    private function processPembayaranPenuh($validated, $calonSiswa, $biayaPendaftaran, $kodePembayaran, $buktiPembayaranPath)
    {
        Pembayaran::create([
            'calon_siswa_id' => $calonSiswa->id,
            'biaya_pendaftaran_id' => $biayaPendaftaran->id,
            'detail_angsuran_id' => null,
            'kode_pembayaran' => $kodePembayaran,
            'jumlah' => $validated['jumlah'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'jenis_pembayaran' => 'penuh',
            'bukti_pembayaran_path' => $buktiPembayaranPath,
            'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
            'status' => 'berhasil',
            'catatan' => $validated['catatan'],
            'keterangan_angsuran' => null
        ]);
    }

    private function processPembayaranDP($validated, $calonSiswa, $biayaPendaftaran, $kodePembayaran, $buktiPembayaranPath)
    {
        // 1. Simpan pembayaran DP
        Pembayaran::create([
            'calon_siswa_id' => $calonSiswa->id,
            'biaya_pendaftaran_id' => $biayaPendaftaran->id,
            'detail_angsuran_id' => null,
            'kode_pembayaran' => $kodePembayaran,
            'jumlah' => $validated['jumlah'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'jenis_pembayaran' => 'dp_angsuran',
            'bukti_pembayaran_path' => $buktiPembayaranPath,
            'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
            'status' => 'berhasil',
            'catatan' => $validated['catatan'],
            'keterangan_angsuran' => 'Pembayaran DP untuk ' . $validated['jumlah_cicilan'] . ' kali cicilan'
        ]);

        // 2. Buat rencana angsuran
        $sisaHutang = $biayaPendaftaran->jumlah - $validated['jumlah'];
        $nominalPerCicilan = $sisaHutang / $validated['jumlah_cicilan'];

        $kodeAngsuran = 'ANG-' . date('Y') . '-' . str_pad($calonSiswa->id, 4, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 99), 2, '0', STR_PAD_LEFT);

        $tanggalSelesai = Carbon::parse($validated['tanggal_mulai_cicilan'])->addMonths($validated['jumlah_cicilan'] - 1);

        $rencanaAngsuran = RencanaAngsuran::create([
            'calon_siswa_id' => $calonSiswa->id,
            'biaya_pendaftaran_id' => $biayaPendaftaran->id,
            'kode_angsuran' => $kodeAngsuran,
            'total_biaya' => $biayaPendaftaran->jumlah,
            'dp_dibayar' => $validated['jumlah'],
            'sisa_hutang' => $sisaHutang,
            'jumlah_cicilan' => $validated['jumlah_cicilan'],
            'nominal_per_cicilan' => $nominalPerCicilan,
            'tanggal_mulai' => $validated['tanggal_mulai_cicilan'],
            'tanggal_selesai' => $tanggalSelesai,
            'status' => 'aktif',
            'catatan' => 'Rencana angsuran dibuat otomatis dari pembayaran DP'
        ]);

        // 3. Generate detail cicilan
        $this->generateDetailCicilan($rencanaAngsuran, $validated['tanggal_mulai_cicilan'], $validated['jumlah_cicilan'], $nominalPerCicilan);
    }

    private function processPembayaranCicilan($validated, $calonSiswa, $biayaPendaftaran, $kodePembayaran, $buktiPembayaranPath)
    {
        $detailAngsuran = DetailAngsuran::findOrFail($validated['detail_angsuran_id']);

        // 1. Simpan pembayaran cicilan
        Pembayaran::create([
            'calon_siswa_id' => $calonSiswa->id,
            'biaya_pendaftaran_id' => $biayaPendaftaran->id,
            'detail_angsuran_id' => $detailAngsuran->id,
            'kode_pembayaran' => $kodePembayaran,
            'jumlah' => $validated['jumlah'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'jenis_pembayaran' => 'cicilan_angsuran',
            'bukti_pembayaran_path' => $buktiPembayaranPath,
            'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
            'status' => 'berhasil',
            'catatan' => $validated['catatan'],
            'keterangan_angsuran' => 'Pembayaran cicilan ke-' . $detailAngsuran->cicilan_ke
        ]);

        // 2. Update status detail angsuran
        $detailAngsuran->update([
            'total_bayar' => $validated['jumlah'],
            'tanggal_bayar' => $validated['tanggal_pembayaran'],
            'status' => 'dibayar'
        ]);

        // 3. Cek apakah semua cicilan sudah lunas
        $rencanaAngsuran = $detailAngsuran->rencanaAngsuran;
        $sisaCicilan = $rencanaAngsuran->detailAngsuran()->where('status', '!=', 'dibayar')->count();

        if ($sisaCicilan == 0) {
            $rencanaAngsuran->update(['status' => 'lunas']);
        }

        // 4. Update sisa hutang
        $totalDibayar = $rencanaAngsuran->detailAngsuran()->where('status', 'dibayar')->sum('total_bayar');
        $rencanaAngsuran->update([
            'sisa_hutang' => $rencanaAngsuran->total_biaya - $rencanaAngsuran->dp_dibayar - $totalDibayar
        ]);
    }

    private function generateDetailCicilan($rencanaAngsuran, $tanggalMulai, $jumlahCicilan, $nominalPerCicilan)
    {
        $tanggalJatuhTempo = Carbon::parse($tanggalMulai);

        for ($i = 1; $i <= $jumlahCicilan; $i++) {
            DetailAngsuran::create([
                'rencana_angsuran_id' => $rencanaAngsuran->id,
                'cicilan_ke' => $i,
                'nominal_cicilan' => $nominalPerCicilan,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo->copy(),
                'denda' => 0,
                'total_bayar' => null,
                'tanggal_bayar' => null,
                'status' => 'belum_bayar',
                'catatan' => 'Cicilan ke-' . $i . ' dari ' . $jumlahCicilan
            ]);

            // Tambah satu bulan untuk cicilan selanjutnya
            $tanggalJatuhTempo->addMonth();
        }
    }

    private function getSuccessMessage($jenisPembayaran)
    {
        switch ($jenisPembayaran) {
            case 'penuh':
                return 'Pembayaran penuh berhasil disimpan';
            case 'dp_angsuran':
                return 'Pembayaran DP berhasil disimpan. Rencana angsuran telah dibuat.';
            case 'cicilan_angsuran':
                return 'Pembayaran cicilan berhasil disimpan';
            default:
                return 'Pembayaran berhasil disimpan';
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
