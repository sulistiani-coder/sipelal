<x-layouts.app title="Tambah Kategori">
    <div class="space-y-6">
        <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Tambah Kategori</h1>
        <form method="POST" action="{{ route('admin.kategori.store') }}" class="space-y-6">
            @csrf
            <div class="rounded-2xl border border-primary-100 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
                <div class="space-y-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Nama *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.kategori.index') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-primary-50 dark:border-slate-600 dark:text-slate-300">Batal</a>
                <button type="submit" class="rounded-xl bg-primary-600 px-6 py-2.5 text-sm font-bold text-white transition hover:bg-primary-700">Simpan</button>
            </div>
        </form>
    </div>
</x-layouts.app>
