<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.siswa.index');
    }

    public function datatable()
    {
        $siswa = Siswa::with(['calonSiswa.tahunAjaran', 'riwayatKelas'])
            ->get();

        return datatables()->of($siswa)
            ->addIndexColumn()
            ->addColumn('nama_lengkap', function ($row) {
                return $row->calonSiswa->nama_lengkap;
            })
            ->addColumn('tempat_tanggal_lahir', function ($row) {
                return $row->calonSiswa->tempat_lahir . ', ' . Carbon::parse($row->calonSiswa->tanggal_lahir)->isoFormat('D MMMM Y');
            })
            ->addColumn('jenis_kelamin', function ($row) {
                return $row->calonSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
            })
            ->addColumn('tahun_masuk', function ($row) {
                return $row->calonSiswa->tahunAjaran ? $row->calonSiswa->tahunAjaran->nama_tahun_ajaran : 'Tidak diketahui';
            })
            ->addColumn('kelas_awal', function ($row) {
                return $row->kelas_awal;
            })
            ->addColumn('current_class', function ($row) {
                return $row->kelasAktif() ? $row->kelasAktif()->kelas->nama_kelas : 'Belum ada kelas';
            })
            ->addColumn('status', function ($row) {
                $status = $row->kelasAktif() ? $row->kelasAktif()->status : 'Belum Ada Kelas';
                $badges = [
                    'aktif' => 'success',
                    'lulus' => 'primary',
                    'pindah' => 'warning',
                    'dropout' => 'danger',
                    'Belum Ada Kelas' => 'secondary'
                ];
                $color = $badges[$status] ?? 'secondary';
                return "<span class='badge bg-{$color}'>{$status}</span>";
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<button type="button" class="btn btn-sm btn-warning me-1 btn-edit" data-id="' . $row->id . '">Edit</button>';
                $btn .= '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        //
    }
}
