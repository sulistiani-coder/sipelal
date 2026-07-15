<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.theme === 'dark' }" x-bind:class="dark ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - {{ config('branding.nama_lab', 'SIPELAL') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-['Inter',sans-serif] antialiased">

    <div class="flex min-h-screen">
        {{-- KIRI: GRADIENT --}}
        <div class="hidden relative overflow-hidden bg-gradient-to-br from-primary-600 to-violet-600 lg:flex lg:w-1/2">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wOCI+PHBhdGggZD0iTTM2IDM0djItSDI0di0yaDEyem0wLTR2MkgzNHYyaDEyeiIvPjwvZz48L2c+PC9zdmc+')]"></div>
            <div class="relative z-10 flex flex-col justify-center px-12 xl:px-16">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo-kampus.png') }}" alt="Logo" class="h-10" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    <div class="hidden h-10 w-10 items-center justify-center rounded-xl bg-white/20 text-lg font-bold text-white">S</div>
                </div>
                <h1 class="mt-8 text-4xl font-extrabold leading-tight text-white xl:text-5xl">Kelola Peminjaman Alat Lab Lebih Mudah</h1>
                <p class="mt-4 max-w-md text-lg text-primary-100">{{ config('branding.nama_kampus') }}</p>

                <div class="mt-10 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/20">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-sm text-primary-100">Proses peminjaman cepat tanpa antre</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/20">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-sm text-primary-100">Approval 2-tingkat yang terkontrol</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/20">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-sm text-primary-100">Pantau status peminjaman real-time</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN: FORM --}}
        <div class="flex w-full items-center justify-center px-6 py-12 lg:w-1/2">
            <div class="w-full max-w-md">
                <div class="mb-8 flex items-center gap-3 lg:hidden">
                    <img src="{{ asset('img/logo-kampus.png') }}" alt="Logo" class="h-8" onerror="this.style.display='none'">
                    <span class="text-xl font-bold text-slate-900">SIPELAL</span>
                </div>

                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Masuk ke Akun</h2>
                <p class="mt-2 text-sm text-slate-500">Silakan masukkan email dan password Anda.</p>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20"
                            placeholder="nama@kampus.ac.id">
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20"
                            placeholder="Masukkan password">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-slate-600">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-primary-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-primary-600/25 transition hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Masuk
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-500">Daftar sekarang</a>
                </p>

                <div class="mt-6">
                    <a href="{{ url('/') }}" class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Beranda
                    </a>
                </div>

                <div class="mt-8 rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-medium text-slate-500">Akun Demo:</p>
                    <div class="mt-2 space-y-1 text-xs text-slate-600">
                        <p><strong>Super Admin:</strong> admin@sipelal.test / password</p>
                        <p><strong>Admin Lab:</strong> admin1@sipelal.test / password</p>
                        <p><strong>Dosen:</strong> dosen1@sipelal.test / password</p>
                        <p><strong>Mahasiswa:</strong> mahasiswa1@sipelal.test / password</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
