<x-layouts.app title="Kelola Denda">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Kelola Denda</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Pantau dan kelola denda seluruh peminjaman</p>
        </div>

        <form method="GET" class="rounded-2xl border border-primary-100 bg-white p-4 dark:border-slate-700 dark:bg-slate-800">
            <div class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode pinjam, nama..." class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                </div>
                <div>
                    <select name="status" class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
                <button type="submit" class="rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700">Filter</button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('super-admin.fines.index') }}" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-50 dark:border-slate-600 dark:text-slate-300">Reset</a>
                @endif
            </div>
        </form>

        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-primary-100 dark:border-slate-700">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Kode Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Hari Terlambat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Jumlah Denda</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Catatan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($fines as $fine)
                        <tr class="transition hover:bg-primary-50 dark:hover:bg-slate-700/30">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $fine->loan->kode_pinjam ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $fine->loan->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $fine->jumlah_hari }} hari</td>
                            <td class="px-6 py-4 font-semibold text-red-600">Rp {{ number_format($fine->jumlah_denda, 0, ',', '.') }}</td>
                            <td class="px-6 py-4"><x-badge-status :status="$fine->is_paid ? 'ACTIVE' : 'PENDING'" :label="$fine->is_paid ? 'Lunas' : 'Belum Bayar'" /></td>
                            <td class="px-6 py-4 text-xs text-slate-500 max-w-[200px] truncate">{{ $fine->catatan_admin ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                @if(!$fine->is_paid)
                                    <form method="POST" action="{{ route('super-admin.fines.mark-paid', $fine) }}">
                                        @csrf
                                        <button class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-700">Tandai Lunas</button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada data denda</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-primary-100 px-6 py-3 dark:border-slate-700">
                {{ $fines->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
