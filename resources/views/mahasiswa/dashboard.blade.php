<x-layouts.app title="Dashboard Mahasiswa">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Dashboard Mahasiswa</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Selamat datang, {{ auth()->user()->name }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="rounded-2xl border border-primary-100 bg-white p-5 dark:border-slate-700 dark:bg-slate-800">
                <p class="text-xs text-slate-500">Total Peminjaman</p>
                <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">{{ $myLoans }}</p>
            </div>
            <div class="rounded-2xl border border-primary-200 bg-primary-50 p-5 dark:border-primary-800 dark:bg-primary-900/10">
                <p class="text-xs text-primary-700">Sedang Aktif</p>
                <p class="mt-1 text-2xl font-bold text-primary-700 dark:text-primary-400">{{ $activeLoans }}</p>
            </div>
            <div class="rounded-2xl border border-primary-100 bg-white p-5 dark:border-slate-700 dark:bg-slate-800">
                <p class="text-xs text-slate-500">Denda Belum Bayar</p>
                <p class="mt-1 text-2xl font-bold {{ $myFines > 0 ? 'text-red-600' : 'text-slate-900 dark:text-white' }}">{{ $myFines }}</p>
            </div>
            <div>
                <a href="{{ route('pinjam.create') }}" class="flex h-full min-h-[88px] items-center justify-center rounded-2xl border-2 border-dashed border-primary-300 bg-primary-50/50 p-5 text-sm font-semibold text-primary-600 transition hover:border-primary-400 hover:bg-primary-100 dark:border-primary-700 dark:bg-primary-900/10 dark:text-primary-400">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Ajukan Pinjam
                </a>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
                <div class="border-b border-primary-100 px-6 py-4 dark:border-slate-700">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">Peminjaman Terbaru</h2>
                </div>
                <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($recentLoans as $loan)
                        <div class="flex items-center justify-between px-6 py-3">
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $loan->kode_pinjam }}</p>
                                <p class="text-xs text-slate-500">{{ $loan->tgl_ambil?->format('d M Y') }} - {{ $loan->tgl_kembali_rencana?->format('d M Y') }}</p>
                            </div>
                            <x-badge-status :status="$loan->status" />
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada peminjaman</div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-primary-100 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Menu Cepat</h2>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <a href="{{ route('pinjam.create') }}" class="flex items-center gap-3 rounded-xl border border-primary-200 p-4 transition hover:bg-primary-50 dark:border-primary-800 dark:hover:bg-primary-900/10">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100 dark:bg-primary-900/30">
                            <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Pinjam</p>
                            <p class="text-xs text-slate-500">Ajukan baru</p>
                        </div>
                    </a>
                    <a href="{{ route('katalog.index') }}" class="flex items-center gap-3 rounded-xl border border-primary-200 p-4 transition hover:bg-primary-50 dark:border-primary-800 dark:hover:bg-primary-900/10">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/30">
                            <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Katalog</p>
                            <p class="text-xs text-slate-500">Lihat alat</p>
                        </div>
                    </a>
                    <a href="{{ route('riwayat.index') }}" class="flex items-center gap-3 rounded-xl border border-primary-200 p-4 transition hover:bg-primary-50 dark:border-primary-800 dark:hover:bg-primary-900/10">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 dark:bg-amber-900/30">
                            <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Riwayat</p>
                            <p class="text-xs text-slate-500">Cek status</p>
                        </div>
                    </a>
                    <a href="{{ route('denda.index') }}" class="flex items-center gap-3 rounded-xl border border-primary-200 p-4 transition hover:bg-primary-50 dark:border-primary-800 dark:hover:bg-primary-900/10">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 dark:bg-red-900/30">
                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Denda</p>
                            <p class="text-xs text-slate-500">Lihat denda</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
