<?php

namespace App\Http\Controllers;

use App\Models\KuotaPendaftaran;
use App\Models\TahunAjaran;
use App\Models\JalurPendaftaran;
use Illuminate\Http\Request;

class KuotaPendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kuota = KuotaPendaftaran::with(['tahunAjaran', 'jalurPendaftaran'])
            ->orderBy('tahun_ajaran_id')
            ->get();
        $tahunAjaran = TahunAjaran::where('status_aktif', true)->get();
        $jalurPendaftaran = JalurPendaftaran::where('aktif', true)->get();

        return view('master.kuota-pendaftaran.index', compact('kuota', 'tahunAjaran', 'jalurPendaftaran'));
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
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'jalur_pendaftaran_id' => 'required|exists:jalur_pendaftaran,id',
            'kuota' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        // Check if kuota already exists for this combination
        $exists = KuotaPendaftaran::where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('jalur_pendaftaran_id', $validated['jalur_pendaftaran_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota untuk jalur dan tahun ajaran ini sudah ada'
            ], 422);
        }

        $kuota = KuotaPendaftaran::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kuota pendaftaran berhasil ditambahkan',
            'data' => $kuota->load(['tahunAjaran', 'jalurPendaftaran'])
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(KuotaPendaftaran $kuotaPendaftaran)
    {
        return response()->json([
            'success' => true,
            'data' => $kuotaPendaftaran->load(['tahunAjaran', 'jalurPendaftaran'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KuotaPendaftaran $kuotaPendaftaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KuotaPendaftaran $kuotaPendaftaran)
    {
        $validated = $request->validate([
            'kuota' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $kuotaPendaftaran->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kuota pendaftaran berhasil diperbarui',
            'data' => $kuotaPendaftaran->fresh(['tahunAjaran', 'jalurPendaftaran'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KuotaPendaftaran $kuotaPendaftaran)
    {
        $kuotaPendaftaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kuota pendaftaran berhasil dihapus'
        ]);
    }
}
