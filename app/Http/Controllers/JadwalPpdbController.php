<?php

namespace App\Http\Controllers;

use App\Models\JadwalPpdb;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalPpdbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwalPpdbs = JadwalPpdb::with('tahunAjaran')->orderBy('tanggal_mulai', 'asc')->get();
        $tahunAjarans = TahunAjaran::orderBy('nama_tahun_ajaran', 'asc')->get();

        return view('master.jadwal-ppdb.index', compact('jadwalPpdbs', 'tahunAjarans'));
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
            'nama_jadwal' => 'required|string|max:255',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string'
        ]);

        JadwalPpdb::create($validated);

        return redirect()->route('admin.jadwal-ppdb.index')
            ->with('success', 'Jadwal PPDB berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalPpdb $jadwalPpdb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalPpdb $jadwalPpdb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalPpdb $jadwalPpdb)
    {
        $validated = $request->validate([
            'nama_jadwal' => 'required|string|max:255',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string'
        ]);

        $jadwalPpdb->update($validated);

        return redirect()->route('admin.jadwal-ppdb.index')
            ->with('success', 'Jadwal PPDB berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalPpdb $jadwalPpdb)
    {
        $jadwalPpdb->delete();

        return redirect()->route('admin.jadwal-ppdb.index')
            ->with('success', 'Jadwal PPDB berhasil dihapus');
    }
}
