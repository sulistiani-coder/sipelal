<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-900 antialiased">
    <div class="min-h-screen" style="background-image: linear-gradient(135deg, rgba(2, 6, 23, 0.88), rgba(15, 23, 42, 0.72)), url('https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1600&q=80'); background-size: cover; background-position: center;">
        <div class="min-h-screen bg-slate-950/30 backdrop-blur-sm">
            <header class="border-b border-white/10 bg-white/10 backdrop-blur-md">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/20 text-lg font-semibold text-white shadow-lg">S</div>
                        <div>
                            <p class="text-lg font-semibold text-white">SIPELAL</p>
                            <p class="text- uppercase tracking-[0.35em] text-slate-200">Laboratory Loan System</p>
                        </div>
                    </a>

                    @auth
                        <div class="flex items-center gap-4">
                            {{-- MENU NOTIFIKASI - UDAH GUE BENERIN --}}
                            <a href="{{ route('notifikasi') }}" class="relative rounded-full border border-white/20 bg-white/15 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/25">
                                Notifikasi
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>

                            <a href="{{ url('/dashboard') }}" class="rounded-full border border-white/20 bg-white/15 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/25">Dashboard</a>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="rounded-full border border-white/20 bg-white/15 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/25">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full bg-cyan-500 px-4 py-2 text-sm font-semibold text-white shadow-lg transition hover:bg-cyan-400">Daftar</a>
                            @endif
                        </div>
                    @endauth
                </div>
            </header>

            <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8 lg:py-16">
                <div class="rounded- border border-white/20 bg-white/85 p-4 shadow-2xl shadow-slate-950/20 backdrop-blur-xl sm:p-6 lg:p-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>