<x-layouts.app title="Edit Alat">
    <div class="space-y-6" x-data="alatForm()">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Edit Alat</h1>
        </div>

        <form method="POST" action="{{ route('admin.alat.update', $alat) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            <div class="rounded-2xl border border-primary-100 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Kode *</label>
                        <input type="text" name="kode" value="{{ old('kode', $alat->kode) }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Kategori *</label>
                        <select name="category_id" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            @foreach(\App\Models\EquipmentCategory::all() as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $alat->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Laboratorium</label>
                        <select name="lab_id" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">Pilih Lab</option>
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}" {{ old('lab_id', $alat->lab_id) == $lab->id ? 'selected' : '' }}>{{ $lab->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Nama *</label>
                        <input type="text" name="name" value="{{ old('name', $alat->name) }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Merk</label>
                        <input type="text" name="merk" value="{{ old('merk', $alat->merk) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Model</label>
                        <input type="text" name="model" value="{{ old('model', $alat->model) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Spesifikasi</label>
                        <textarea name="spesifikasi" rows="3" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">{{ old('spesifikasi', $alat->spesifikasi) }}</textarea>
                    </div>
                </div>

                {{-- Existing photos --}}
                <div class="mt-4">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Foto Saat Ini</label>
                    @if($alat->foto && count($alat->foto) > 0)
                        <div class="flex flex-wrap gap-3 mb-3">
                            @foreach($alat->foto as $idx => $foto)
                                <div class="relative">
                                    <img src="{{ Storage::disk('public')->url($foto) }}" alt="Foto {{ $idx+1 }}" class="h-24 w-24 rounded-xl object-cover ring-2 ring-slate-200 dark:ring-slate-600">
                                    <label class="absolute -top-2 -right-2 flex h-5 w-5 cursor-pointer items-center justify-center rounded-full bg-red-500 text-xs text-white shadow hover:bg-red-600">
                                        <input type="checkbox" name="hapus_foto[]" value="{{ $foto }}" class="hidden">
                                        &times;
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-400">Belum ada foto</p>
                    @endif

                    <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Tambah Foto Baru (maks 5, jpg/png/webp, max 2MB per file)</label>
                    <input type="file" name="foto[]" multiple accept="image/*" @change="previewImages($event)" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white file:mr-3 file:rounded-lg file:border-0 file:bg-primary-50 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-primary-600 hover:file:bg-primary-100">
                    <div class="mt-3 flex flex-wrap gap-3" x-show="previews.length > 0">
                        <template x-for="(src, idx) in previews" :key="idx">
                            <div class="relative">
                                <img :src="src" class="h-24 w-24 rounded-xl object-cover ring-2 ring-slate-200 dark:ring-slate-600">
                                <button type="button" @click="removePreview(idx)" class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white shadow">&times;</button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.alat.index') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-primary-50 dark:border-slate-600 dark:text-slate-300">Batal</a>
                <button type="submit" class="rounded-xl bg-primary-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-primary-600/25 transition hover:bg-primary-700">Perbarui</button>
            </div>
        </form>
    </div>

    <script>
        function alatForm() {
            return {
                previews: [],
                previewImages(event) {
                    const files = event.target.files;
                    for (let i = 0; i < files.length && this.previews.length < 5; i++) {
                        if (files[i].size > 2 * 1024 * 1024) {
                            alert('File ' + files[i].name + ' melebihi 2MB');
                            continue;
                        }
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            if (this.previews.length < 5) this.previews.push(e.target.result);
                        };
                        reader.readAsDataURL(files[i]);
                    }
                },
                removePreview(idx) {
                    this.previews.splice(idx, 1);
                }
            }
        }
    </script>
</x-layouts.app>
