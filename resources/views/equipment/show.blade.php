<x-layouts.app title="{{ $equipment->name }}">
    <div class="space-y-6">
        <a href="{{ route('katalog.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-primary-600 dark:text-slate-400">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Katalog
        </a>

        <div class="rounded-2xl border border-primary-100 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
            {{-- Photo Gallery --}}
            @if($equipment->foto && count($equipment->foto) > 0)
                <div x-data="{ active: 0 }" class="mb-6">
                    <div class="relative overflow-hidden rounded-xl bg-slate-100 dark:bg-slate-700" style="aspect-ratio: 16/9;">
                        @foreach($equipment->foto as $idx => $foto)
                            <img src="{{ Storage::disk('public')->url($foto) }}" alt="{{ $equipment->name }}" x-show="active === {{ $idx }}" x-transition class="absolute inset-0 h-full w-full object-contain">
                        @endforeach
                    </div>
                    @if(count($equipment->foto) > 1)
                        <div class="mt-3 flex gap-2 overflow-x-auto pb-1">
                            @foreach($equipment->foto as $idx => $foto)
                                <button @click="active = {{ $idx }}" :class="active === {{ $idx }} ? 'ring-2 ring-primary-500' : 'opacity-60'" class="flex-shrink-0">
                                    <img src="{{ Storage::disk('public')->url($foto) }}" alt="Thumb {{ $idx+1 }}" class="h-16 w-16 rounded-lg object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="mb-6 flex h-48 w-full items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700">
                    <svg class="h-16 w-16 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            @endif

            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $equipment->name }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $equipment->kode }}</p>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-medium text-slate-500">Kategori</p>
                    <p class="text-sm text-slate-900 dark:text-white">{{ $equipment->category->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Merk / Model</p>
                    <p class="text-sm text-slate-900 dark:text-white">{{ $equipment->merk ?? '-' }} {{ $equipment->model }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-medium text-slate-500">Spesifikasi</p>
                    <p class="text-sm text-slate-900 dark:text-white">{{ $equipment->spesifikasi ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Unit Tersedia</h2>
                <div class="mt-3 space-y-2">
                    @foreach($equipment->units as $unit)
                        <div class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-2.5 dark:border-slate-600">
                            <div class="flex items-center gap-3">
                                <span class="font-mono text-xs text-slate-600 dark:text-slate-400">{{ $unit->unit_code }}</span>
                                <x-badge-status :status="$unit->kondisi" />
                            </div>
                            <span class="text-xs text-slate-500">{{ $unit->lokasi ?? '-' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            @php($availableCount = $equipment->units()->where('is_active', true)->where('kondisi', 'BAIK')->count())
            @if($availableCount > 0 && auth()->user()->hasRole(['mahasiswa', 'dosen']))
                <div class="mt-6">
                    <a href="{{ route('pinjam.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-primary-700">Ajukan Peminjaman</a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
