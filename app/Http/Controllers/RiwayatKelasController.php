<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatKelasController extends Controller
{
    public function index()
    {
        // Ambil data riwayat kelas untuk siswa yang sedang login
        $siswa = auth()->user()->siswa;
        $riwayatKelas = $siswa->riwayatKelas()
            ->with(['kelas', 'tahunAjaran'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.riwayat-kelas', compact('riwayatKelas'));
    }
}
