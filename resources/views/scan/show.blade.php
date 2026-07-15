<x-layouts.app title="Detail Peminjaman - {{ $loan->kode_pinjam }}">
    <div class="space-y-6">
        <a href="{{ route('scan.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-primary-600 dark:text-slate-400">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Scanner
        </a>

        <div class="rounded-2xl border border-primary-100 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $loan->kode_pinjam }}</h1>
                    <p class="mt-1 text-sm text-slate-500">UUID: <code class="rounded bg-slate-100 px-1.5 py-0.5 text-xs dark:bg-slate-700">{{ $loan->uuid }}</code></p>
                </div>
                <x-badge-status :status="$loan->status" />
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-medium text-slate-500">Peminjam</p>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $loan->user->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Dosen Pembimbing</p>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $loan->dosen->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Tanggal Ambil</p>
                    <p class="text-sm text-slate-900 dark:text-white">{{ $loan->tgl_ambil?->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Rencana Kembali</p>
                    <p class="text-sm text-slate-900 dark:text-white">{{ $loan->tgl_kembali_rencana?->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Tujuan</p>
                    <p class="text-sm text-slate-900 dark:text-white">{{ $loan->tujuan }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Mata Kuliah</p>
                    <p class="text-sm text-slate-900 dark:text-white">{{ $loan->mata_kuliah ?? '-' }}</p>
                </div>
            </div>

            {{-- QR Code --}}
            <div class="mt-6 flex justify-center">
                <div class="rounded-xl bg-white p-4 shadow-inner">
                    {!! QrCode::size(180)->generate($loan->uuid) !!}
                </div>
            </div>
            <p class="mt-2 text-center text-xs text-slate-400">QR Code untuk peminjaman ini</p>

            {{-- Alat yang Dipinjam --}}
            <div class="mt-6">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Alat yang Dipinjam</h2>
                <div class="mt-3 space-y-2">
                    @foreach($loan->loanItems as $item)
                        <div class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 dark:border-slate-600">
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $item->equipmentUnit->equipment->name ?? '-' }}</p>
                                <p class="text-xs text-slate-500">{{ $item->equipmentUnit->unit_code ?? '-' }} | Kondisi: {{ $item->kondisi_saat_pinjam }}</p>
                            </div>
                            @if($item->kondisi_saat_kembali)
                                <x-badge-status :status="$item->kondisi_saat_kembali" />
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Denda --}}
            @if($loan->fine)
                <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20">
                    <h3 class="text-sm font-bold text-red-700 dark:text-red-400">Denda</h3>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-300">
                        Terlambat {{ $loan->fine->jumlah_hari }} hari | Rp {{ number_format($loan->fine->jumlah_denda, 0, ',', '.') }}
                        @if($loan->fine->is_paid)
                            <span class="ml-2 inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Lunas</span>
                        @else
                            <span class="ml-2 inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">Belum Bayar</span>
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
