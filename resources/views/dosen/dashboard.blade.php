<x-layouts.app title="Dashboard Dosen">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Dashboard Dosen</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola persetujuan peminjaman mahasiswa</p>
        </div>

        <div class="grid grid-cols-2 gap-4 lg:grid-cols-3">
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 dark:border-amber-800 dark:bg-amber-900/10">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 dark:bg-amber-900/30">
                        <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-amber-700">Perlu Approval</p>
                        <p class="text-2xl font-bold text-amber-700 dark:text-amber-400">{{ $pendingApprovals }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-primary-100 bg-white p-5 dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/30">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Sudah Disetujui</p>
                        <p class="text-2xl font-bold text-emerald-600">{{ $approvedLoans }}</p>
                    </div>
                </div>
            </div>
            <div class="col-span-2 lg:col-span-1">
                <a href="{{ route('pinjam.create') }}" class="flex h-full items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 p-5 text-sm font-semibold text-slate-500 transition hover:border-primary-400 hover:text-primary-600 dark:border-slate-600 dark:hover:border-primary-500">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Ajukan Peminjaman
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="border-b border-primary-100 px-6 py-4 dark:border-slate-700">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Menunggu Persetujuan Anda</h2>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                @forelse($recentLoans as $loan)
                    <div class="flex items-center justify-between px-6 py-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">{{ strtoupper(substr($loan->user->name ?? '?', 0, 2)) }}</div>
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $loan->kode_pinjam }}</p>
                                <p class="text-xs text-slate-500">{{ $loan->user->name ?? '-' }} - {{ $loan->tgl_ambil?->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('dosen.approval.approve', $loan) }}">
                                @csrf
                                <button class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700">Setuju</button>
                            </form>
                            <form method="POST" action="{{ route('dosen.approval.reject', $loan) }}">
                                @csrf
                                <button class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">Tolak</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400">Tidak ada peminjaman menunggu persetujuan</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
