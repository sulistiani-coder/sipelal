<x-layouts.app>
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-300 bg-slate-100 p-6 shadow-sm">
            <h1 class="text-2xl font-semibold text-slate-900">Dashboard Admin</h1>
            <p class="mt-3 text-slate-600">Ringkasan operasional laboratorium SIPELAL.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-300 bg-slate-50 p-6 shadow-sm">
                <p class="text-sm text-slate-600">Total Peralatan</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalEquipment }}</p>
            </div>
            <div class="rounded-2xl border border-slate-300 bg-slate-50 p-6 shadow-sm">
                <p class="text-sm text-slate-600">Total Unit</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalUnits }}</p>
            </div>
            <div class="rounded-2xl border border-slate-300 bg-slate-50 p-6 shadow-sm">
                <p class="text-sm text-slate-600">Kategori</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalCategories }}</p>
            </div>
            <div class="rounded-2xl border border-slate-300 bg-slate-50 p-6 shadow-sm">
                <p class="text-sm text-slate-600">Permintaan Pending</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $pendingLoans }}</p>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <a href="{{ route('admin.alat.index') }}" class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-900">Manajemen Alat</h2>
                <p class="mt-2 text-sm text-slate-600">Tambah, ubah, atau hapus peralatan lab.</p>
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-900">Manajemen Kategori</h2>
                <p class="mt-2 text-sm text-slate-600">Kelola kategori peralatan.</p>
            </a>
            <a href="{{ route('admin.approval.index') }}" class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-900">Persetujuan Peminjaman</h2>
                <p class="mt-2 text-sm text-slate-600">Review peminjaman baru dan proses serah terima.</p>
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-900">Laporan</h2>
                <p class="mt-2 text-sm text-slate-600">Eksport data peminjaman ke PDF.</p>
            </a>
        </div>
    </div>
</x-layouts.app>
