<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .filter-info {
            margin-bottom: 15px;
        }

        .total-info {
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Pembayaran</h2>
        <p>{{ config('app.name') }}</p>
    </div>

    @if (request('start_date') || request('end_date'))
        <div class="filter-info">
            <strong>Periode:</strong>
            {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->isoFormat('D MMMM Y') : '' }}
            {{ request('start_date') && request('end_date') ? 's/d' : '' }}
            {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->isoFormat('D MMMM Y') : '' }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Jalur</th>
                <th>Tahun Ajaran</th>
                <th>Jenis Biaya</th>
                <th>Metode</th>
                <th class="text-right">Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($pembayarans as $index => $pembayaran)
                @php $total += $pembayaran->jumlah; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->isoFormat('D MMM Y') }}</td>
                    <td>{{ $pembayaran->calonSiswa->nama_lengkap }}</td>
                    <td>{{ $pembayaran->calonSiswa->jalurPendaftaran->nama_jalur ?? 'N/A' }}</td>
                    <td>{{ $pembayaran->biayaPendaftaran->tahunAjaran->nama_tahun_ajaran }}</td>
                    <td>{{ $pembayaran->biayaPendaftaran->jenis_biaya }}</td>
                    <td>{{ ucfirst($pembayaran->metode_pembayaran) }}</td>
                    <td class="text-right">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($pembayaran->status) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="total-info">
        <p><strong>Total Transaksi:</strong> {{ $pembayarans->count() }}</p>
        <p><strong>Total Pembayaran:</strong> Rp {{ number_format($total, 0, ',', '.') }}</p>
    </div>
</body>

</html>
