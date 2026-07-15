<x-layouts.app title="Katalog Alat">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Katalog Alat</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Browse dan cari peralatan laboratorium</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($equipments as $alat)
                <a href="{{ route('katalog.show', $alat->kode) }}" class="group rounded-2xl border border-primary-100 bg-white p-5 transition-all duration-200 hover:scale-[1.01] hover:shadow-lg dark:border-slate-700 dark:bg-slate-800">
                    <div class="h-36 w-full overflow-hidden rounded-xl bg-slate-100 dark:bg-slate-700">
                        @if($alat->foto && count($alat->foto) > 0)
                            <img src="{{ Storage::disk('public')->url($alat->foto[0]) }}" alt="{{ $alat->name }}" class="h-full w-full object-cover transition group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <svg class="h-12 w-12 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                        @endif
                    </div>
                    <h3 class="mt-3 text-base font-bold text-slate-900 group-hover:text-primary-600 dark:text-white">{{ $alat->name }}</h3>
                    <p class="mt-1 text-xs text-slate-500">{{ $alat->kode }} | {{ $alat->category->name ?? '-' }}</p>
                    @if($alat->merk)
                        <p class="mt-1 text-xs text-slate-400">{{ $alat->merk }} {{ $alat->model }}</p>
                    @endif
                    <div class="mt-3 flex items-center gap-2">
                        @php
                            $availableUnits = $alat->units()->where('is_active', true)->where('kondisi', 'BAIK')->count();
                        @endphp
                        @if($availableUnits > 0)
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Tersedia ({{ $availableUnits }} unit)</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">Stok Habis</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-full">
                    <x-empty-state icon="inbox" title="Belum ada alat" description="Belum ada peralatan yang tersedia di katalog." />
                </div>
            @endforelse
        </div>
        <div>{{ $equipments->links() }}</div>
    </div>
</x-layouts.app>
