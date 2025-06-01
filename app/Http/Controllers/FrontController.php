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
        $jalurPendaftarans = \App\Models\JalurPendaftaran::where('aktif', true)
            ->with(['kuotaPendaftaran' => function ($query) use ($tahunAjaranAktif) {
                $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);
            }])
            ->get();

        // Get PPDB schedules
        $jadwalPpdb = \App\Models\JadwalPpdb::where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->orderBy('tanggal_mulai')
            ->get();

        return view('landing.pendaftaran', [
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'jalurPendaftarans' => $jalurPendaftarans,
            'jadwalPpdb' => $jadwalPpdb
        ]);
    }
}
