<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahunAjarans = TahunAjaran::latest()->get();
        return view('master.tahunajaran.index', compact('tahunAjarans'));
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
        $request->validate([
            'nama_tahun_ajaran' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_aktif' => 'required|boolean',
        ]);

        TahunAjaran::create($request->all());

        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TahunAjaran $tahunAjaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return response()->json($tahunAjaran);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'nama_tahun_ajaran' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_aktif' => 'required|boolean',
        ]);

        // Jika status diubah menjadi aktif, nonaktifkan semua tahun ajaran lain
        if ($request->status_aktif == true) {
            TahunAjaran::where('id', '!=', $tahunAjaran->id)
                ->update(['status_aktif' => false]);
        }

        $tahunAjaran->update($request->all());

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();
        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil dihapus.');
    }
}
