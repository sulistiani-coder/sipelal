<x-layouts.app>
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-300 bg-slate-100 p-6 shadow-sm">
            @php
                $roleLabel = 'Mahasiswa';
                if (auth()->user()->hasAnyRole(['admin_lab', 'super_admin'])) {
                    $roleLabel = 'Admin';
                } elseif (auth()->user()->hasRole('dosen')) {
                    $roleLabel = 'Dosen';
                }
            @endphp
            <h1 class="text-2xl font-semibold text-slate-900">Dashboard {{ $roleLabel }}</h1>
            <p class="mt-3 text-slate-600">Total alat di katalog: <strong>{{ $equipmentCount }}</strong></p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <a href="{{ route('katalog.index') }}" class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-900">Katalog</h2>
                <p class="mt-2 text-sm text-slate-600">Lihat semua peralatan yang tersedia di laboratorium.</p>
            </a>

            @if (auth()->user()->hasRole('mahasiswa'))
                <a href="{{ route('pinjam.create') }}" class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:bg-slate-50">
                    <h2 class="text-lg font-semibold text-slate-900">Pinjam</h2>
                    <p class="mt-2 text-sm text-slate-600">Ajukan permintaan peminjaman alat.</p>
                </a>
                <a href="{{ route('denda.index') }}" class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:bg-slate-50">
                    <h2 class="text-lg font-semibold text-slate-900">Denda</h2>
                    <p class="mt-2 text-sm text-slate-600">Lihat denda peminjaman jika ada.</p>
                </a>
            @elseif (auth()->user()->hasRole('dosen'))
                <a href="{{ route('riwayat.index') }}" class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:bg-slate-50">
                    <h2 class="text-lg font-semibold text-slate-900">Riwayat</h2>
                    <p class="mt-2 text-sm text-slate-600">Cek riwayat pinjaman Anda.</p>
                </a>
                <div class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-900">Akses Dosen</h2>
                    <p class="mt-2 text-sm text-slate-600">Anda dapat melihat katalog dan riwayat pinjaman, tetapi tidak membuat permintaan pinjaman.</p>
                </div>
            @else
                <a href="{{ route('riwayat.index') }}" class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:bg-slate-50">
                    <h2 class="text-lg font-semibold text-slate-900">Riwayat</h2>
                    <p class="mt-2 text-sm text-slate-600">Cek status peminjaman dan riwayat peminjaman Anda.</p>
                </a>
            @endif

            @if (auth()->user()->hasAnyRole(['admin_lab', 'super_admin']))
                <a href="{{ route('admin.dashboard') }}" class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm transition hover:border-primary-300 hover:bg-slate-50">
                    <h2 class="text-lg font-semibold text-slate-900">Admin Panel</h2>
                    <p class="mt-2 text-sm text-slate-600">Akses manajemen peralatan dan persetujuan peminjaman.</p>
                </a>
            @endif
        </div>
    </div>
</x-layouts.app>
