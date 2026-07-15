<x-layouts.app title="Kelola Unit">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Kelola Unit</h1>
            <a href="{{ route('admin.unit.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Unit
            </a>
        </div>
        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-primary-100 dark:border-slate-700">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Kode Unit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Alat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Kondisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($units as $unit)
                        <tr>
                            <td class="px-6 py-4 font-mono text-xs text-slate-600 dark:text-slate-400">{{ $unit->unit_code }}</td>
                            <td class="px-6 py-4 text-slate-900 dark:text-white">{{ $unit->equipment->name ?? '-' }}</td>
                            <td class="px-6 py-4"><x-badge-status :status="$unit->kondisi" /></td>
                            <td class="px-6 py-4">
                                @if($unit->is_active)
                                    <span class="text-xs text-emerald-600 font-medium">Aktif</span>
                                @else
                                    <span class="text-xs text-red-600 font-medium">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.unit.edit', $unit) }}" class="rounded-lg bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-sm text-slate-400">Belum ada unit</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-primary-100 px-6 py-3 dark:border-slate-700">{{ $units->links() }}</div>
        </div>
    </div>
</x-layouts.app>
