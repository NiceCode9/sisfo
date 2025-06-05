<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PembayaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $pembayaran;

    public function __construct($pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function collection()
    {
        return $this->pembayaran;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kode Pembayaran',
            'Nama Siswa',
            'Jalur',
            'Tahun Ajaran',
            'Jenis Biaya',
            'Jumlah',
            'Metode',
            'Status'
        ];
    }

    public function map($pembayaran): array
    {
        return [
            $pembayaran->tanggal_pembayaran ? date('d/m/Y', strtotime($pembayaran->tanggal_pembayaran)) : '-',
            $pembayaran->kode_pembayaran,
            $pembayaran->calonSiswa->nama_lengkap,
            $pembayaran->jalur_pendaftaran->nama_jalur,
            $pembayaran->tahun_ajaran->nama_tahun_ajaran,
            $pembayaran->biayaPendaftaran->jenis_biaya,
            $pembayaran->jumlah,
            ucfirst($pembayaran->metode_pembayaran),
            ucfirst($pembayaran->status)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style for header row
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4A90E2'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Apply borders to all cells with data
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:I' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Center align specific columns
        $sheet->getStyle('A:B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Right align amount column
        $sheet->getStyle('G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Format amount column as currency
        $sheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0');

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
