<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }

    public function pendaftaran()
    {
        $tahunAjaranAktif = TahunAjaran::where('status_aktif', true)->first();

        return view('landing.pendaftaran', [
            'jadwalPendaftaran' => $tahunAjaranAktif->pendaftaran_mulai . ' - ' . $tahunAjaranAktif->pendaftaran_selesai,
            'jadwalTesMasuk' => $tahunAjaranAktif->tes_mulai,
            'jadwalPengumuman' => $tahunAjaranAktif->pengumuman_mulai
        ]);
    }
}
