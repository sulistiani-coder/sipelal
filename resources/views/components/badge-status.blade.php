@props(['status' => 'default', 'label' => null])

@php
    $statusColors = [
        'PENDING' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        'DISETUJUI_DOSEN' => 'bg-primary-100 text-primary-800 dark:bg-primary-900/30 dark:text-primary-400',
        'DISETUJUI_ADMIN' => 'bg-primary-100 text-primary-800 dark:bg-primary-900/30 dark:text-primary-400',
        'DITOLAK' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        'DIPINJAM' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
        'DIKEMBALIKAN' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
        'TERLAMBAT' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
        'DIBATALKAN' => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
        'BAIK' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
        'PERLU_PERHATIAN' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        'RUSAK_RINGAN' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
        'RUSAK_BERAT' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        'TIDAK_BISA_DIPINJAM' => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
        'ACTIVE' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
        'PENDING' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        'SUSPENDED' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    ];

    $labels = [
        'PENDING' => 'Menunggu Dosen',
        'DISETUJUI_DOSEN' => 'Menunggu Admin',
        'DITOLAK' => 'Ditolak',
        'DIPINJAM' => 'Dipinjam',
        'DIKEMBALIKAN' => 'Dikembalikan',
        'TERLAMBAT' => 'Terlambat',
        'DIBATALKAN' => 'Dibatalkan',
        'BAIK' => 'Baik',
        'PERLU_PERHATIAN' => 'Perlu Perhatian',
        'RUSAK_RINGAN' => 'Rusak Ringan',
        'RUSAK_BERAT' => 'Rusak Berat',
        'TIDAK_BISA_DIPINJAM' => 'Tidak Bisa Dipinjam',
        'ACTIVE' => 'Aktif',
        'SUSPENDED' => 'Ditangguhkan',
    ];

    $colorClass = $statusColors[$status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300';
    $displayLabel = $label ?? ($labels[$status] ?? $status);
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $colorClass }}">
    {{ $displayLabel }}
</span>
