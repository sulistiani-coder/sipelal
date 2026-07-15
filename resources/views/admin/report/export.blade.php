<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Peminjaman SIPELAL</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .kop-table { width: 100%; border: none; margin-bottom: 5px; }
        .kop-table td { border: none; vertical-align: middle; padding: 5px; }
        .kop-center { text-align: center; }
        .kop-line { border-top: 2px solid #000; margin-top: 5px; }
        .kop-line2 { border-top: 1px solid #000; margin-top: 2px; margin-bottom: 15px; }
        h1 { text-align: center; font-size: 14px; margin: 10px 0 5px; text-transform: uppercase; }
        h2 { font-size: 12px; margin: 10px 0 5px; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; }
        table.data th, table.data td { border: 1px solid #666; padding: 5px 6px; text-align: left; }
        table.data th { background: #e5e7eb; font-weight: bold; font-size: 9px; text-transform: uppercase; }
        .footer { margin-top: 20px; font-size: 9px; text-align: right; }
        .ttd { margin-top: 30px; }
        .ttd-table { width: 100%; }
        .ttd-table td { width: 50%; vertical-align: top; padding: 10px; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td width="15%">
                <img src="{{ public_path('img/logo-kampus.png') }}" width="60" onerror="this.style.display='none'">
            </td>
            <td width="70%" class="kop-center">
                <strong style="font-size: 13px;">{{ config('branding.nama_kampus', 'UNIVERSITAS XXX') }}</strong><br>
                <strong style="font-size: 11px;">{{ config('branding.nama_lab', 'LABORATORIUM TEKNOLOGI INFORMASI') }}</strong><br>
                <span style="font-size: 9px;">Gedung A Lantai 2 | lab@kampus.ac.id</span>
            </td>
            <td width="15%"></td>
        </tr>
    </table>
    <div class="kop-line"></div>
    <div class="kop-line2"></div>

    <h1>Laporan Peminjaman Alat Laboratorium</h1>
    <p style="text-align: center; font-size: 10px; color: #666;">Periode: {{ $periode ?? 'Semua Data' }}</p>
    <p style="text-align: center; font-size: 10px; color: #666;">Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>

    <table class="data">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Kode</th>
                <th width="18%">Peminjam</th>
                <th width="16%">Alat</th>
                <th width="10%">Status</th>
                <th width="10%">Tgl Pinjam</th>
                <th width="10%">Tgl Kembali</th>
                <th width="10%">Terlambat</th>
                <th width="10%">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($loans as $i => $loan)
            <tr>
                <td align="center">{{ $i + 1 }}</td>
                <td>{{ $loan->kode_pinjam }}</td>
                <td>{{ $loan->user->name ?? '-' }}</td>
                <td>
                    @foreach($loan->loanItems as $item)
                        {{ $item->equipmentUnit->equipment->name ?? '-' }}@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td align="center">{{ $loan->status }}</td>
                <td>{{ $loan->tgl_ambil?->format('d/m/Y') }}</td>
                <td>{{ $loan->tgl_kembali_rencana?->format('d/m/Y') }}</td>
                <td align="center">
                    @if($loan->tgl_kembali_aktual && $loan->tgl_kembali_aktual->gt($loan->tgl_kembali_rencana))
                        {{ $loan->tgl_kembali_rencana->diffInDays($loan->tgl_kembali_aktual) }} hari
                    @else
                        -
                    @endif
                </td>
                <td align="right">
                    @if($loan->fine)
                        Rp {{ number_format($loan->fine->jumlah_denda, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" align="center">Tidak ada data peminjaman</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd">
        <table class="ttd-table">
            <tr>
                <td></td>
                <td class="kop-center">
                    Dikeluarkan di: {{ config('branding.nama_kampus', 'Kota') }}<br>
                    Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><br><br><br>
                    <strong>________________</strong><br>
                    Admin {{ config('branding.nama_lab', 'Lab TI') }}
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
