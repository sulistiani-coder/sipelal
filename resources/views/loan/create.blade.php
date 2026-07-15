<x-layouts.app title="Ajukan Peminjaman">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Ajukan Peminjaman</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Isi form berikut untuk mengajukan peminjaman alat</p>
        </div>

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pinjam.store') }}" class="space-y-6">
            @csrf

            <div class="rounded-2xl border border-primary-100 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-4 text-base font-bold text-slate-900 dark:text-white">Informasi Peminjaman</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Ambil *</label>
                        <input type="date" name="tgl_ambil" value="{{ old('tgl_ambil') }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Rencana Kembali *</label>
                        <input type="date" name="tgl_kembali_rencana" value="{{ old('tgl_kembali_rencana') }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Tujuan *</label>
                        <select name="tujuan" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">Pilih tujuan</option>
                            @foreach($tujuanOptions as $opt)
                                <option value="{{ $opt }}" {{ old('tujuan') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Mata Kuliah</label>
                        <select name="mata_kuliah" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">Pilih mata kuliah</option>
                            @foreach($mataKuliahOptions as $opt)
                                <option value="{{ $opt }}" {{ old('mata_kuliah') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Dosen Pembimbing *</label>
                        <select name="dosen_id" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">Pilih dosen pembimbing</option>
                            @foreach($dosenList as $dosen)
                                <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>{{ $dosen->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Catatan</label>
                        <textarea name="catatan" rows="2" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white" placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-primary-100 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-4 text-base font-bold text-slate-900 dark:text-white">Pilih Alat *</h2>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($units as $unit)
                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-3 transition hover:border-primary-400 hover:bg-primary-50/50 dark:border-slate-600 dark:hover:border-primary-500 {{ in_array($unit->id, old('units', [])) ? 'border-primary-500 bg-primary-50 dark:border-primary-500' : '' }}">
                            <input type="checkbox" name="units[]" value="{{ $unit->id }}" {{ in_array($unit->id, old('units', [])) ? 'checked' : '' }} class="mt-0.5 h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $unit->equipment->name ?? '-' }}</p>
                                <p class="text-xs text-slate-500">{{ $unit->unit_code }} | {{ $unit->kondisi }}</p>
                            </div>
                        </label>
                    @empty
                        <div class="col-span-full py-8 text-center text-sm text-slate-400">Tidak ada alat tersedia</div>
                    @endforelse
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('dashboard') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-primary-50 dark:border-slate-600 dark:text-slate-300">Batal</a>
                <button type="submit" class="rounded-xl bg-primary-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-primary-600/25 transition hover:bg-primary-700">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</x-layouts.app>
