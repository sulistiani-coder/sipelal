<x-layouts.app title="Approval Peminjaman">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Approval Peminjaman</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Review dan setujui peminjaman mahasiswa bimbingan Anda</p>
        </div>

        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-primary-100 dark:border-slate-700">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Mahasiswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Tujuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($loans as $loan)
                        <tr class="transition hover:bg-primary-50 dark:hover:bg-slate-700/30">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $loan->kode_pinjam }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $loan->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $loan->tujuan }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $loan->tgl_ambil?->format('d M Y') }} - {{ $loan->tgl_kembali_rencana?->format('d M Y') }}</td>
                            <td class="px-6 py-4"><x-badge-status :status="$loan->status" /></td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('dosen.approval.approve', $loan) }}">
                                        @csrf
                                        <button class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-700">Setuju</button>
                                    </form>
                                    <form method="POST" action="{{ route('dosen.approval.reject', $loan) }}">
                                        @csrf
                                        <button class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-700">Tolak</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-sm text-slate-400">Tidak ada peminjaman menunggu persetujuan</div>
                            </td>
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
