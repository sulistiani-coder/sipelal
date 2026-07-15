<x-layouts.app title="Laporan">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Laporan Peminjaman</h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.export-excel', request()->query()) }}" class="inline-flex items-center gap-2 rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-900/50">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export Excel
                </a>
                <a href="{{ route('admin.laporan.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export PDF
                </a>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.laporan.index') }}" class="rounded-2xl border border-primary-100 bg-white p-4 dark:border-slate-700 dark:bg-slate-800">
            <div class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-700 dark:text-slate-300">Dari Tanggal</label>
                    <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-700 dark:text-slate-300">Sampai Tanggal</label>
                    <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                </div>
                <button type="submit" class="rounded-xl bg-primary-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-primary-700">Filter</button>
                @if(request()->hasAny(['dari', 'sampai']))
                    <a href="{{ route('admin.laporan.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-primary-50 dark:border-slate-600 dark:text-slate-300">Reset</a>
                @endif
            </div>
        </form>

        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-primary-100 dark:border-slate-700">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Tgl Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Tgl Kembali</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($loans as $i => $loan)
                        <tr class="transition hover:bg-primary-50 dark:hover:bg-slate-700/30">
                            <td class="px-6 py-4 text-slate-500">{{ ($loans->currentPage() - 1) * $loans->perPage() + $i + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $loan->kode_pinjam }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $loan->user->name ?? '-' }}</td>
                            <td class="px-6 py-4"><x-badge-status :status="$loan->status" /></td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $loan->tgl_ambil?->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $loan->tgl_kembali_rencana?->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-primary-100 px-6 py-3 dark:border-slate-700">
                {{ $loans->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
