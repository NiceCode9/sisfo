<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\TahunAjaran;
use App\Models\JalurPendaftaran;
use App\Exports\PembayaranExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjaran = TahunAjaran::orderBy('nama_tahun_ajaran', 'desc')->get();
        $jalurPendaftaran = JalurPendaftaran::all();

        if ($request->ajax()) {
            $query = Pembayaran::with([
                'calonSiswa' => function ($q) {
                    $q->with('jalurPendaftaran');
                },
                'biayaPendaftaran' => function ($q) {
                    $q->with('tahunAjaran');
                }
            ]);

            // Filter by tahun ajaran
            if ($request->filled('tahun_ajaran_id')) {
                $query->whereHas('biayaPendaftaran.tahunAjaran', function ($q) use ($request) {
                    $q->where('id', $request->tahun_ajaran_id);
                });
            }

            // Filter by jalur pendaftaran
            if ($request->filled('jalur_pendaftaran_id')) {
                $query->whereHas('calonSiswa', function ($q) use ($request) {
                    $q->where('jalur_pendaftaran_id', $request->jalur_pendaftaran_id);
                });
            }

            // Filter by status pembayaran
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by tanggal
            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('tanggal_pembayaran', '>=', $request->tanggal_mulai);
            }
            if ($request->filled('tanggal_selesai')) {
                $query->whereDate('tanggal_pembayaran', '<=', $request->tanggal_selesai);
            }

            // Get statistics for filtered data
            $filteredData = clone $query;
            $statistik = [
                'total_pembayaran' => $filteredData->count(),
                'total_nominal' => $filteredData->sum('jumlah')
            ];

            return DataTables::of($query)
                ->addColumn('tanggal_pembayaran', function ($row) {
                    return $row->tanggal_pembayaran ? date('d/m/Y', strtotime($row->tanggal_pembayaran)) : '-';
                })
                ->addColumn('nama_lengkap', function ($row) {
                    return $row->calonSiswa->nama_lengkap;
                })
                ->addColumn('nama_jalur', function ($row) {
                    return $row->calonSiswa->jalurPendaftaran->nama_jalur;
                })
                ->addColumn('jenis_biaya', function ($row) {
                    return $row->biayaPendaftaran->jenis_biaya;
                })
                ->addColumn('jumlah', function ($row) {
                    return 'Rp ' . number_format($row->jumlah, 0, ',', '.');
                })
                ->addColumn('metode_pembayaran', function ($row) {
                    return ucfirst($row->metode_pembayaran);
                })
                ->addColumn('status', function ($row) {
                    $badges = [
                        'berhasil' => '<span class="badge bg-success">Berhasil</span>',
                        'menunggu' => '<span class="badge bg-warning">Menunggu</span>',
                        'gagal' => '<span class="badge bg-danger">Gagal</span>'
                    ];
                    return $badges[$row->status] ?? '<span class="badge bg-secondary">Unknown</span>';
                })
                ->rawColumns(['status'])
                ->with(['statistik' => $statistik])
                ->make(true);
        }

        // Initial statistics for page load
        $statistik = [
            'total_pembayaran' => Pembayaran::count(),
            'total_nominal' => Pembayaran::sum('jumlah')
        ];

        return view('laporan.pembayaran.index', compact('statistik', 'tahunAjaran', 'jalurPendaftaran'));
    }

    public function exportExcel(Request $request)
    {
        $query = $this->getQueryWithFilters($request);
        $pembayaran = $query->get();

        return Excel::download(new PembayaranExport($pembayaran), 'laporan-pembayaran-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = $this->getQueryWithFilters($request);
        $pembayarans = $query->get();

        $pdf = PDF::loadView('laporan.pembayaran.pdf', [
            'pembayarans' => $pembayarans,
            'total' => $pembayarans->sum('jumlah'),
            'filter' => [
                'tahun_ajaran' => $request->filled('tahun_ajaran_id') ? TahunAjaran::find($request->tahun_ajaran_id)?->nama_tahun_ajaran : 'Semua',
                'jalur' => $request->filled('jalur_pendaftaran_id') ? JalurPendaftaran::find($request->jalur_pendaftaran_id)?->nama_jalur : 'Semua',
                'status' => $request->status ? ucfirst($request->status) : 'Semua',
                'tanggal_mulai' => $request->tanggal_mulai ? date('d/m/Y', strtotime($request->tanggal_mulai)) : '-',
                'tanggal_selesai' => $request->tanggal_selesai ? date('d/m/Y', strtotime($request->tanggal_selesai)) : '-',
            ]
        ]);


        return $pdf->stream('laporan-pembayaran-' . date('Y-m-d') . '.pdf');
    }

    private function getQueryWithFilters(Request $request)
    {
        $query = Pembayaran::with([
            'calonSiswa' => function ($q) {
                $q->with('jalurPendaftaran');
            },
            'biayaPendaftaran' => function ($q) {
                $q->with('tahunAjaran');
            }
        ]);

        if ($request->filled('tahun_ajaran_id')) {
            $query->whereHas('biayaPendaftaran.tahunAjaran', function ($q) use ($request) {
                $q->where('id', $request->tahun_ajaran_id);
            });
        }

        if ($request->filled('jalur_pendaftaran_id')) {
            $query->whereHas('calonSiswa', function ($q) use ($request) {
                $q->where('jalur_pendaftaran_id', $request->jalur_pendaftaran_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_pembayaran', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_pembayaran', '<=', $request->tanggal_selesai);
        }

        return $query;
    }
}
