<x-layouts.app title="Semua Peminjaman">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Semua Peminjaman Sistem</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Lihat seluruh data peminjaman dari semua role</p>
        </div>

        <form method="GET" class="rounded-2xl border border-primary-100 bg-white p-4 dark:border-slate-700 dark:bg-slate-800">
            <div class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode pinjam, nama..." class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                </div>
                <div>
                    <select name="status" class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>Menunggu Dosen</option>
                        <option value="DISETUJUI_DOSEN" {{ request('status') === 'DISETUJUI_DOSEN' ? 'selected' : '' }}>Menunggu Admin</option>
                        <option value="DIPINJAM" {{ request('status') === 'DIPINJAM' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="DIKEMBALIKAN" {{ request('status') === 'DIKEMBALIKAN' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="TERLAMBAT" {{ request('status') === 'TERLAMBAT' ? 'selected' : '' }}>Terlambat</option>
                        <option value="DITOLAK" {{ request('status') === 'DITOLAK' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700">Filter</button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('super-admin.loans.index') }}" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-50 dark:border-slate-600 dark:text-slate-300">Reset</a>
                @endif
            </div>
        </form>

        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-primary-100 dark:border-slate-700">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Dosen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Alat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($loans as $loan)
                        <tr class="transition hover:bg-primary-50 dark:hover:bg-slate-700/30">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                                <a href="{{ route('super-admin.loans.show', $loan) }}" class="text-primary-600 hover:underline dark:text-primary-400">{{ $loan->kode_pinjam }}</a>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $loan->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $loan->dosen->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                @foreach($loan->loanItems as $item)
                                    <span class="inline-block rounded-full bg-slate-100 px-2 py-0.5 text-xs dark:bg-slate-700">{{ $item->equipmentUnit->equipment->name ?? '-' }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $loan->tgl_ambil?->format('d M Y') }}</td>
                            <td class="px-6 py-4"><x-badge-status :status="$loan->status" /></td>
                            <td class="px-6 py-4">
                                @if($loan->fine)
                                    <span class="text-xs font-medium {{ $loan->fine->is_paid ? 'text-emerald-600' : 'text-red-600' }}">Rp {{ number_format($loan->fine->jumlah_denda, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada data peminjaman</td>
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
