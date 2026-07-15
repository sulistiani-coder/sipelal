<x-layouts.app title="Activity Log">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Activity Log</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Riwayat aktivitas sistem</p>
        </div>

        {{-- Filters --}}
        <div class="rounded-2xl border border-primary-100 bg-white p-4 dark:border-slate-700 dark:bg-slate-800">
            <form method="GET" class="flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[200px]">
                    <label class="mb-1 block text-xs font-medium text-slate-500">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas..." class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                </div>
                <div class="min-w-[160px]">
                    <label class="mb-1 block text-xs font-medium text-slate-500">Log Name</label>
                    <select name="log_name" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        <option value="">Semua</option>
                        @foreach($logNames as $name)
                            <option value="{{ $name }}" {{ request('log_name') === $name ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="rounded-xl bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700">Filter</button>
                @if(request()->hasAny(['search', 'log_name']))
                    <a href="{{ route('super-admin.activity-log') }}" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-primary-50 dark:border-slate-600 dark:text-slate-300">Reset</a>
                @endif
            </form>
        </div>

        {{-- Activity Table --}}
        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-primary-100 dark:border-slate-700">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Oleh</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Event</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Log</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Properties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($activities as $activity)
                        <tr class="transition hover:bg-primary-50 dark:hover:bg-slate-700/30">
                            <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">{{ $activity->created_at?->format('d M Y H:i:s') }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white whitespace-nowrap">{{ $activity->causer->name ?? 'System' }}</td>
                            <td class="px-6 py-4">
                                @if($activity->event)
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                        {{ $activity->event === 'created' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : '' }}
                                        {{ $activity->event === 'updated' ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400' : '' }}
                                        {{ $activity->event === 'deleted' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                        {{ $activity->event }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $activity->description }}</td>
                            <td class="px-6 py-4 text-xs text-slate-400">{{ $activity->log_name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($activity->properties && count($activity->properties) > 0)
                                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-xs text-primary-600 hover:underline dark:text-primary-400">Lihat</button>
                                    <pre class="hidden mt-1 max-w-xs overflow-auto rounded-lg bg-slate-50 p-2 text-xs text-slate-600 dark:bg-slate-900 dark:text-slate-400">{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada activity log</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-primary-100 px-6 py-3 dark:border-slate-700">
                {{ $activities->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
