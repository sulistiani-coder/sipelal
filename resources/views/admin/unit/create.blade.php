<x-layouts.app title="Tambah Unit">
    <div class="space-y-6">
        <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Tambah Unit Baru</h1>
        <form method="POST" action="{{ route('admin.unit.store') }}" class="space-y-6">
            @csrf
            <div class="rounded-2xl border border-primary-100 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Alat *</label>
                        <select name="equipment_id" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">Pilih Alat</option>
                            @foreach($equipments as $eq)
                                <option value="{{ $eq->id }}">{{ $eq->name }} ({{ $eq->kode }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Kode Unit *</label>
                        <input type="text" name="unit_code" value="{{ old('unit_code') }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white" placeholder="KD-LAB-001-A">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Kondisi *</label>
                        <select name="kondisi" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="BAIK">Baik</option>
                            <option value="PERLU_PERHATIAN">Perlu Perhatian</option>
                            <option value="RUSAK_RINGAN">Rusak Ringan</option>
                            <option value="RUSAK_BERAT">Rusak Berat</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.unit.index') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-primary-50 dark:border-slate-600 dark:text-slate-300">Batal</a>
                <button type="submit" class="rounded-xl bg-primary-600 px-6 py-2.5 text-sm font-bold text-white transition hover:bg-primary-700">Simpan</button>
            </div>
        </form>
    </div>
</x-layouts.app>
