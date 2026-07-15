<x-layouts.app title="Denda Saya">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Denda Saya</h1>
        </div>

        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-primary-100 dark:border-slate-700">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Kode Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Jumlah Hari</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Denda</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($fines as $fine)
                        <tr class="transition hover:bg-primary-50 dark:hover:bg-slate-700/30">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $fine->loan->kode_pinjam ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $fine->jumlah_hari }} hari</td>
                            <td class="px-6 py-4 font-semibold text-red-600">Rp {{ number_format($fine->jumlah_denda, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($fine->is_paid)
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">Lunas</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-400">Belum Bayar</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada denda</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
