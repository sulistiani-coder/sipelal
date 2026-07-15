<x-layouts.app title="Edit Unit">
    <div class="space-y-6">
        <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Edit Unit</h1>
        <form method="POST" action="{{ route('admin.unit.update', $unit) }}" class="space-y-6">
            @csrf @method('PUT')
            <div class="rounded-2xl border border-primary-100 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Alat *</label>
                        <select name="equipment_id" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            @foreach($equipments as $eq)
                                <option value="{{ $eq->id }}" {{ old('equipment_id', $unit->equipment_id) == $eq->id ? 'selected' : '' }}>{{ $eq->name }} ({{ $eq->kode }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Kode Unit *</label>
                        <input type="text" name="unit_code" value="{{ old('unit_code', $unit->unit_code) }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Kondisi *</label>
                        <select name="kondisi" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            @foreach(['BAIK','PERLU_PERHATIAN','RUSAK_RINGAN','RUSAK_BERAT','TIDAK_BISA_DIPINJAM'] as $k)
                                <option value="{{ $k }}" {{ old('kondisi', $unit->kondisi) === $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $unit->lokasi) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $unit->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-primary-600">
                            <span class="text-sm text-slate-700 dark:text-slate-300">Aktif</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.unit.index') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-primary-50 dark:border-slate-600 dark:text-slate-300">Batal</a>
                <button type="submit" class="rounded-xl bg-primary-600 px-6 py-2.5 text-sm font-bold text-white transition hover:bg-primary-700">Perbarui</button>
            </div>
        </form>
    </div>
</x-layouts.app>
