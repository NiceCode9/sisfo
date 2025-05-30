<?php

namespace App\Http\Controllers;

use App\Models\JalurPendaftaran;
use Illuminate\Http\Request;

class JalurPendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jalurPendaftarans = JalurPendaftaran::all();
        return view('master.jalur-pendaftaran.index', compact('jalurPendaftarans'));
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
            'nama_jalur' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'aktif' => 'required|boolean'
        ]);

        JalurPendaftaran::create($request->all());

        return redirect()->route('admin.jalur-pendaftaran.index')
            ->with('success', 'Jalur Pendaftaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JalurPendaftaran $jalurPendaftaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JalurPendaftaran $jalurPendaftaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JalurPendaftaran $jalurPendaftaran)
    {
        $request->validate([
            'nama_jalur' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'aktif' => 'required|boolean'
        ]);

        $jalurPendaftaran->update($request->all());

        return redirect()->route('admin.jalur-pendaftaran.index')
            ->with('success', 'Jalur Pendaftaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JalurPendaftaran $jalurPendaftaran)
    {
        $jalurPendaftaran->delete();

        return redirect()->route('admin.jalur-pendaftaran.index')
            ->with('success', 'Jalur Pendaftaran berhasil dihapus');
    }
}
