<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $loans;

    public function __construct($loans)
    {
        $this->loans = $loans;
    }

    public function collection()
    {
        return $this->loans;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Pinjam',
            'Peminjam',
            'Dosen Pembimbing',
            'Tujuan',
            'Mata Kuliah',
            'Alat',
            'Status',
            'Tgl Ambil',
            'Tgl Kembali Rencana',
            'Tgl Kembali Aktual',
            'Terlambat (hari)',
            'Denda (Rp)',
        ];
    }

    public function map($loan): array
    {
        $alat = $loan->loanItems->map(function ($item) {
            return $item->equipmentUnit->equipment->name ?? '-';
        })->implode(', ');

        $terlambat = 0;
        if ($loan->tgl_kembali_aktual && $loan->tgl_kembali_aktual->gt($loan->tgl_kembali_rencana)) {
            $terlambat = $loan->tgl_kembali_rencana->diffInDays($loan->tgl_kembali_aktual);
        }

        return [
            '',
            $loan->kode_pinjam,
            $loan->user->name ?? '-',
            $loan->dosen->name ?? '-',
            $loan->tujuan,
            $loan->mata_kuliah ?? '-',
            $alat,
            $loan->status,
            $loan->tgl_ambil?->format('d/m/Y'),
            $loan->tgl_kembali_rencana?->format('d/m/Y'),
            $loan->tgl_kembali_aktual?->format('d/m/Y'),
            $terlambat > 0 ? $terlambat : '-',
            $loan->fine ? $loan->fine->jumlah_denda : '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 11]],
        ];
    }
}
