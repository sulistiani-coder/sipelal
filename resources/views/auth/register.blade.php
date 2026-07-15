<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.theme === 'dark' }" x-bind:class="dark ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - {{ config('branding.nama_lab', 'SIPELAL') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-['Inter',sans-serif] antialiased">
    <div class="flex min-h-screen">
        <div class="hidden relative overflow-hidden bg-gradient-to-br from-primary-600 to-violet-600 lg:flex lg:w-1/2">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wOCI+PHBhdGggZD0iTTM2IDM0djItSDI0di0yaDEyem0wLTR2MkgzNHYyaDEyeiIvPjwvZz48L2c+PC9zdmc+')]"></div>
            <div class="relative z-10 flex flex-col justify-center px-12 xl:px-16">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo-kampus.png') }}" alt="Logo" class="h-10" onerror="this.style.display='none'">
                </div>
                <h1 class="mt-8 text-4xl font-extrabold leading-tight text-white xl:text-5xl">Bergabung dengan SIPELAL</h1>
                <p class="mt-4 max-w-md text-lg text-primary-100">Daftar untuk mulai meminjam alat laboratorium secara digital.</p>
            </div>
        </div>
        <div class="flex w-full items-center justify-center px-6 py-12 lg:w-1/2">
            <div class="w-full max-w-md">
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Daftar Akun Baru</h2>
                <p class="mt-2 text-sm text-slate-500">Isi data diri Anda untuk membuat akun.</p>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
                    @csrf
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20" placeholder="Nama lengkap">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20" placeholder="nama@kampus.ac.id">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">NIM</label>
                        <input type="text" name="nim" value="{{ old('nim') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20" placeholder="12345678">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Program Studi</label>
                            <input type="text" name="prodi" value="{{ old('prodi') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20" placeholder="Teknik Informatika">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Angkatan</label>
                            <input type="number" name="angkatan" value="{{ old('angkatan') }}" min="2000" max="{{ date('Y') + 1 }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20" placeholder="2024">
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Password *</label>
                        <input type="password" name="password" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20" placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20">
                    </div>
                    <button type="submit" class="w-full rounded-xl bg-primary-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-primary-600/25 transition hover:bg-primary-700">Daftar</button>
                </form>
                <p class="mt-6 text-center text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-500">Masuk</a></p>
            </div>
        </div>
    </div>
</body>
</html>
