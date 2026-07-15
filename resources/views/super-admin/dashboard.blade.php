<x-layouts.app title="Dashboard Super Admin">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Dashboard Super Admin</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Overview seluruh sistem SIPELAL</p>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="rounded-2xl border border-primary-100 bg-white p-5 dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100 dark:bg-primary-900/30">
                        <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Total Alat</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalEquipment }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-primary-100 bg-white p-5 dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/30">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Total User</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-primary-100 bg-white p-5 dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 dark:bg-amber-900/30">
                        <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Pending</p>
                        <p class="text-2xl font-bold text-amber-600">{{ $pendingLoans }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-primary-100 bg-white p-5 dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100 dark:bg-primary-900/30">
                        <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Dipinjam</p>
                        <p class="text-2xl font-bold text-primary-600">{{ $activeLoans }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="border-b border-primary-100 px-6 py-4 dark:border-slate-700">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Peminjaman Terbaru</h2>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                @forelse($recentLoans as $loan)
                    <div class="flex items-center justify-between px-6 py-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">{{ strtoupper(substr($loan->user->name ?? '?', 0, 2)) }}</div>
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $loan->kode_pinjam }}</p>
                                <p class="text-xs text-slate-500">{{ $loan->user->name ?? '-' }}</p>
                            </div>
                        </div>
                        <x-badge-status :status="$loan->status" />
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada peminjaman</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
