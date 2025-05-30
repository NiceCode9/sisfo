<?php

namespace App\Http\Controllers;

use App\Models\BiayaPendaftaran;
use Illuminate\Http\Request;

class BiayaPendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.biaya-pendaftaran.index', [
            'biayaPendaftarans' => BiayaPendaftaran::with('tahunAjaran')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.biaya-pendaftaran.form', [
            'tahunAjarans' => \App\Models\TahunAjaran::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'jenis_biaya' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'wajib_bayar' => 'required|boolean',
            'keterangan' => 'nullable|string|max:500'
        ]);

        BiayaPendaftaran::create($request->all());

        return redirect()->route('admin.biaya-pendaftaran.index')
            ->with('success', 'Biaya Pendaftaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(BiayaPendaftaran $biayaPendaftaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BiayaPendaftaran $biayaPendaftaran)
    {
        return view('master.biaya-pendaftaran.form', [
            'biaya' => $biayaPendaftaran,
            'tahunAjarans' => \App\Models\TahunAjaran::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BiayaPendaftaran $biayaPendaftaran)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'jenis_biaya' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'wajib_bayar' => 'required|boolean',
            'keterangan' => 'nullable|string|max:500'
        ]);

        $biayaPendaftaran->update($request->all());

        return redirect()->route('admin.biaya-pendaftaran.index')
            ->with('success', 'Biaya Pendaftaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BiayaPendaftaran $biayaPendaftaran)
    {
        $biayaPendaftaran->delete();

        return redirect()->route('admin.biaya-pendaftaran.index')
            ->with('success', 'Biaya Pendaftaran berhasil dihapus');
    }
}
