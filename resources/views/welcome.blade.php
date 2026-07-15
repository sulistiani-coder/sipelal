<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.theme === 'dark' || (!localStorage.theme && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-bind:class="dark ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('branding.nama_lab', 'SIPELAL') }} - Sistem Peminjaman Alat Laboratorium</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-white font-['Inter',sans-serif] text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">

    {{-- NAVBAR --}}
    <nav class="sticky top-0 z-50 border-b border-slate-200/60 bg-white/70 backdrop-blur-xl dark:border-slate-700/60 dark:bg-slate-900/70">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('img/logo-kampus.png') }}" alt="Logo" class="h-8" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                <div class="hidden h-8 w-8 items-center justify-center rounded-xl bg-primary-600 text-xs font-bold text-white">S</div>
                <div>
                    <span class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">SIPELAL</span>
                </div>
            </a>
            <nav class="hidden items-center gap-1 md:flex">
                <a href="#fitur" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white">Fitur</a>
                <a href="#alur" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white">Alur</a>
                <a href="#faq" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white">FAQ</a>
                <a href="#kontak" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white">Kontak</a>
            </nav>
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-xl bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-700">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-50 via-white to-violet-50 dark:from-slate-950 dark:via-slate-900 dark:to-primary-950/20"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiM4MTVDRjUiIGZpbGwtb3BhY2l0eT0iMC4wNCI+PHBhdGggZD0iTTM2IDM0djItSDI0di0yaDEyem0wLTR2MkgzNHYyaDEyeiIvPjwvZz48L2c+PC9zdmc+')] opacity-40 dark:opacity-20"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8 lg:py-36">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-primary-200 bg-primary-50 px-3 py-1 text-xs font-medium text-primary-700 dark:border-primary-800 dark:bg-primary-900/30 dark:text-primary-400">
                        <span class="h-1.5 w-1.5 rounded-full bg-primary-500"></span>
                        {{ config('branding.nama_lab', 'Lab TI') }}
                    </div>
                    <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-5xl lg:text-6xl">
                        Kelola Peminjaman
                        <span class="bg-gradient-to-r from-primary-600 to-violet-600 bg-clip-text text-transparent">Alat Lab</span>
                        Lebih Mudah
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-slate-600 dark:text-slate-400">
                        {{ config('branding.nama_kampus', 'Universitas XXX') }} - Sistem informasi terintegrasi untuk peminjaman peralatan laboratorium. Cepat, transparan, dan terpantau.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="#fitur" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition hover:bg-primary-700">
                            Lihat Demo
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        @guest
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                                Login Sekarang
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <div class="absolute -inset-4 rounded-3xl bg-gradient-to-r from-primary-500/20 to-violet-500/20 blur-2xl"></div>
                    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-800">
                        <div class="flex items-center gap-2 border-b border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-900">
                            <span class="h-3 w-3 rounded-full bg-red-400"></span>
                            <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                            <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                            <span class="ml-2 text-xs text-slate-400">SIPELAL Dashboard</span>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-900">
                                    <p class="text-xs text-slate-500">Total Alat</p>
                                    <p class="text-2xl font-bold text-slate-900 dark:text-white">156</p>
                                </div>
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-900">
                                    <p class="text-xs text-slate-500">Dipinjam</p>
                                    <p class="text-2xl font-bold text-primary-600">42</p>
                                </div>
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-900">
                                    <p class="text-xs text-slate-500">Pending</p>
                                    <p class="text-2xl font-bold text-amber-500">8</p>
                                </div>
                            </div>
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 dark:bg-slate-900">
                                    <div class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        <span class="text-xs text-slate-600 dark:text-slate-400">LPJ-2024001 - Ahmad</span>
                                    </div>
                                    <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Dipinjam</span>
                                </div>
                                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 dark:bg-slate-900">
                                    <div class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                        <span class="text-xs text-slate-600 dark:text-slate-400">LPJ-2024002 - Sari</span>
                                    </div>
                                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-medium text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">Menunggu</span>
                                </div>
                                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 dark:bg-slate-900">
                                    <div class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-primary-500"></span>
                                        <span class="text-xs text-slate-600 dark:text-slate-400">LPJ-2024003 - Budi</span>
                                    </div>
                                    <span class="rounded-full bg-primary-100 px-2 py-0.5 text-[10px] font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">Disetujui</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FITUR BENTO --}}
    <section id="fitur" class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Fitur Unggulan</h2>
                <p class="mt-3 text-lg text-slate-600 dark:text-slate-400">Solusi lengkap pengelolaan peminjaman alat laboratorium</p>
            </div>
            <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @php
                $features = [
                    ['icon' => 'search', 'title' => 'Katalog Alat', 'desc' => 'Cari dan filter alat berdasarkan kategori, ketersediaan, dan kondisi secara real-time.'],
                    ['icon' => 'clipboard-list', 'title' => 'Pengajuan Online', 'desc' => 'Ajukan peminjaman alat langsung dari web tanpa perlu datang ke laboratorium.'],
                    ['icon' => 'shield-check', 'title' => 'Approval 2-Tingkat', 'desc' => 'Dosen approve dulu, lalu Admin Lab konfirmasi. Proses lebih terkontrol.'],
                    ['icon' => 'scan-line', 'title' => 'QR Code', 'desc' => 'Scan QR pada alat untuk proses pengembalian yang cepat dan akurat.'],
                    ['icon' => 'banknote', 'title' => 'Denda Otomatis', 'desc' => 'Sistem menghitung denda otomatis H+1 keterlambatan pengembalian.'],
                    ['icon' => 'file-text', 'title' => 'Laporan PDF', 'desc' => 'Export laporan peminjaman dalam format PDF dengan kop surat resmi.'],
                ];
                @endphp
                @foreach($features as $i => $f)
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-lg dark:border-slate-700 dark:bg-slate-800">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100 text-primary-600 transition group-hover:bg-primary-600 group-hover:text-white dark:bg-primary-900/30 dark:text-primary-400">
                        @if($f['icon'] === 'search')
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        @elseif($f['icon'] === 'clipboard-list')
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        @elseif($f['icon'] === 'shield-check')
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        @elseif($f['icon'] === 'scan-line')
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        @elseif($f['icon'] === 'banknote')
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @endif
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">{{ $f['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ALUR 5 STEP --}}
    <section id="alur" class="bg-slate-50 py-20 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Alur Peminjaman</h2>
                <p class="mt-3 text-lg text-slate-600 dark:text-slate-400">5 langkah mudah meminjam alat laboratorium</p>
            </div>
            @php
            $steps = [
                ['num' => '01', 'title' => 'Daftar & Login', 'desc' => 'Mahasiswa mendaftar akun dan login ke sistem.'],
                ['num' => '02', 'title' => 'Pilih Alat', 'desc' => 'Browse katalog, pilih alat yang dibutuhkan.'],
                ['num' => '03', 'title' => 'Ajukan Peminjaman', 'desc' => 'Isi form pengajuan, pilih dosen pembimbing.'],
                ['num' => '04', 'title' => 'Approval', 'desc' => 'Dosen approve, lalu Admin Lab konfirmasi.'],
                ['num' => '05', 'title' => 'Ambil & Kembalikan', 'desc' => 'Ambil alat, gunakan, kembalikan tepat waktu.'],
            ];
            @endphp
            <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5">
                @foreach($steps as $i => $s)
                <div class="relative text-center">
                    @if(!$loop->last)
                        <div class="absolute left-1/2 top-8 hidden h-0.5 w-full bg-primary-200 dark:bg-primary-800 lg:block"></div>
                    @endif
                    <div class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-primary-600 text-lg font-bold text-white shadow-lg shadow-primary-600/25">
                        {{ $s['num'] }}
                    </div>
                    <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white">{{ $s['title'] }}</h3>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $s['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="py-20">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Pertanyaan Umum</h2>
            </div>
            <div class="mt-12 space-y-3" x-data="{ aktif: null }">
                @php
                $faqs = [
                    ['q' => 'Bagaimana jika alat yang dipinjam rusak?', 'a' => 'Segera laporkan ke Admin Lab. Jika kerusakan terjadi karena kelalaian pengguna, akan dikenakan biaya perbaikan sesuai ketentuan yang berlaku.'],
                    ['q' => 'Berapa denda jika terlambat mengembalikan alat?', 'a' => 'Denda sebesar Rp 5.000/hari dihitung otomatis oleh sistem mulai H+1 dari tanggal kembali rencana. Denda dapat dilihat di menu Denda.'],
                    ['q' => 'Siapa yang bisa meminjam alat laboratorium?', 'a' => 'Mahasiswa aktif dan Dosen di ' . config('branding.nama_kampus', 'Universitas XXX') . ' dapat mengajukan peminjaman alat. Mahasiswa perlu menunjuk dosen pembimbing.'],
                    ['q' => 'Bagaimana proses approval peminjaman?', 'a' => 'Peminjaman menggunakan sistem approval 2-tingkat: Dosen pembimbing approve terlebih dahulu, kemudian Admin Lab melakukan konfirmasi akhir sebelum alat bisa diambil.'],
                    ['q' => 'Apakah bisa meminjam alat di luar jadwal praktikum?', 'a' => 'Ya, bisa untuk keperluan tugas mandiri, penelitian skripsi/tesis, atau kegiatan organisasi dengan persetujuan dosen pembimbing.'],
                ];
                @endphp
                @foreach($faqs as $i => $faq)
                <div class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700">
                    <button @click="aktif === {{ $i }} ? aktif = null : aktif = {{ $i }}" class="flex w-full items-center justify-between px-6 py-4 text-left text-sm font-semibold text-slate-900 transition hover:bg-slate-50 dark:text-white dark:hover:bg-slate-800/50">
                        <span>{{ $faq['q'] }}</span>
                        <svg class="h-5 w-5 shrink-0 text-slate-400 transition-transform" :class="aktif === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="aktif === {{ $i }}" x-collapse x-cloak class="px-6 pb-4 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        {{ $faq['a'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-gradient-to-br from-primary-600 to-violet-600 px-8 py-14 shadow-2xl shadow-primary-600/25">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Siap Memulai?</h2>
                <p class="mx-auto mt-4 max-w-xl text-lg text-primary-100">Daftar sekarang dan nikmati kemudahan peminjaman alat laboratorium secara digital.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="rounded-xl bg-white px-6 py-3 text-sm font-bold text-primary-600 shadow-lg transition hover:bg-primary-50">Daftar Gratis</a>
                    @endguest
                    <a href="{{ route('login') }}" class="rounded-xl border border-white/30 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Masuk</a>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer id="kontak" class="border-t border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('img/logo-kampus.png') }}" alt="Logo" class="h-8" onerror="this.style.display='none'">
                        <span class="text-lg font-bold text-slate-900 dark:text-white">SIPELAL</span>
                    </div>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">Sistem Informasi Peminjaman Alat Laboratorium {{ config('branding.nama_kampus') }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Menu</h4>
                    <ul class="mt-3 space-y-2">
                        <li><a href="#fitur" class="text-sm text-slate-600 hover:text-primary-600 dark:text-slate-400">Fitur</a></li>
                        <li><a href="#alur" class="text-sm text-slate-600 hover:text-primary-600 dark:text-slate-400">Alur</a></li>
                        <li><a href="#faq" class="text-sm text-slate-600 hover:text-primary-600 dark:text-slate-400">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Akun</h4>
                    <ul class="mt-3 space-y-2">
                        <li><a href="{{ route('login') }}" class="text-sm text-slate-600 hover:text-primary-600 dark:text-slate-400">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-slate-600 hover:text-primary-600 dark:text-slate-400">Daftar</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Kontak</h4>
                    <ul class="mt-3 space-y-2">
                        <li class="text-sm text-slate-600 dark:text-slate-400">{{ config('branding.nama_lab') }}</li>
                        <li class="text-sm text-slate-600 dark:text-slate-400">lab@kampus.ac.id</li>
                    </ul>
                    <div class="mt-4 flex gap-3">
                        <a href="#" class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-200 text-slate-600 transition hover:bg-primary-100 hover:text-primary-600 dark:bg-slate-700 dark:text-slate-400">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-200 text-slate-600 transition hover:bg-primary-100 hover:text-primary-600 dark:bg-slate-700 dark:text-slate-400">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-10 border-t border-slate-200 pt-6 text-center text-xs text-slate-500 dark:border-slate-700 dark:text-slate-500">
                <!-- GANTI LOGO KAMPUS -->
                &copy; {{ date('Y') }} {{ config('branding.nama_kampus') }}. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    {{-- SCRIPTS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
