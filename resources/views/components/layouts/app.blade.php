@props(['title' => null])

@php
    $user = auth()->user();
    $role = $user->getRoleNames()->first() ?? 'user';
    $unreadCount = $user->unreadNotifications->count();
@endphp

<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.theme === 'dark' || (!localStorage.theme && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-bind:class="dark ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title . ' - ' : '' }}{{ config('branding.nama_lab', 'SIPELAL') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-primary-50 font-['Inter',sans-serif] text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">

    {{-- MOBILE BOTTOM NAV --}}
    <div class="fixed bottom-0 left-0 right-0 z-50 border-t border-primary-200 bg-primary-50/90 backdrop-blur-xl dark:border-slate-700 dark:bg-slate-900/80 md:hidden">
        <nav class="flex items-center justify-around py-2">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs {{ request()->routeIs('*.dashboard') ? 'text-primary-600' : 'text-slate-500' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="{{ route('katalog.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs {{ request()->routeIs('katalog.*') ? 'text-primary-600' : 'text-slate-500' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Katalog
            </a>
            @if($user->hasRole('mahasiswa'))
            <a href="{{ route('pinjam.create') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs {{ request()->routeIs('pinjam.*') ? 'text-primary-600' : 'text-slate-500' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Pinjam
            </a>
            @endif
            @if($user->hasRole(['admin_lab', 'super_admin']))
            <a href="{{ route('scan.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs {{ request()->routeIs('scan.*') ? 'text-primary-600' : 'text-slate-500' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                Scan
            </a>
            @endif
            <a href="{{ route('riwayat.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs {{ request()->routeIs('riwayat.*') ? 'text-primary-600' : 'text-slate-500' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat
            </a>
        </nav>
    </div>

    <div class="flex min-h-screen">
        {{-- SIDEBAR DESKTOP --}}
        <aside class="hidden w-64 flex-col border-r border-primary-200 bg-white dark:border-slate-700 dark:bg-slate-900 md:flex">
            <div class="flex h-16 items-center gap-3 border-b border-primary-100 bg-gradient-to-r from-primary-50 to-white px-5 dark:border-slate-700 dark:from-slate-900 dark:to-slate-900">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-600 text-sm font-bold text-white">S</div>
                <div>
                    <p class="text-sm font-bold leading-tight text-slate-900 dark:text-white">SIPELAL</p>
                    <p class="text-[10px] uppercase tracking-widest text-slate-400">{{ config('branding.nama_lab', 'Lab TI') }}</p>
                </div>
            </div>
            <nav class="flex-1 space-y-1 p-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('*.dashboard') ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('katalog.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('katalog.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Katalog Alat
                </a>
                @if($user->hasRole('mahasiswa'))
                <a href="{{ route('pinjam.create') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('pinjam.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Ajukan Pinjam
                </a>
                <a href="{{ route('riwayat.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('riwayat.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Riwayat
                </a>
                <a href="{{ route('denda.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('denda.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Denda
                </a>
                @endif
                @if($user->hasRole(['dosen']))
                <a href="{{ route('dosen.approval.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('dosen.approval.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Approval Mahasiswa
                </a>
                @endif
                @if($user->hasRole(['admin_lab', 'super_admin']))
                <a href="{{ route('scan.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('scan.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    Scan QR
                </a>
                <a href="{{ route('admin.approval.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.approval.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Approval Admin
                </a>
                <a href="{{ route('admin.alat.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.alat.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Kelola Alat
                </a>
                <a href="{{ route('admin.unit.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.unit.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Kelola Unit
                </a>
                <a href="{{ route('admin.pengembalian.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.pengembalian.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    Pengembalian
                </a>
                <a href="{{ route('riwayat.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('riwayat.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Riwayat
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.laporan.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Laporan
                </a>
                @endif
                @if($user->hasRole('super_admin'))
                <a href="{{ route('super-admin.users.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('super-admin.users.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                    Kelola User
                </a>
                <a href="{{ route('super-admin.loans.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('super-admin.loans.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Semua Pinjaman
                </a>
                <a href="{{ route('super-admin.fines.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('super-admin.fines.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Kelola Denda
                </a>
                <a href="{{ route('super-admin.activity-log') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('super-admin.activity-log') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Activity Log
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.kategori.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kategori
                </a>
                @endif
                @if($user->hasRole('dosen'))
                <a href="{{ route('riwayat.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('riwayat.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:bg-primary-50 dark:text-slate-400 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Riwayat
                </a>
                @endif
            </nav>
            <div class="border-t border-primary-100 p-3 dark:border-slate-700">
                <div class="flex items-center gap-3 rounded-xl px-3 py-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-slate-900 dark:text-white">{{ $user->name }}</p>
                        <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ ucfirst(str_replace('_', ' ', $role)) }}</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex min-w-0 flex-1 flex-col">
            {{-- TOPBAR --}}
            <header class="sticky top-0 z-40 flex h-16 items-center gap-4 border-b border-primary-200 bg-primary-50/80 px-4 backdrop-blur-xl dark:border-slate-700 dark:bg-slate-900/80 sm:px-6">
                <div class="flex items-center gap-3 md:hidden">
                    <a href="{{ url('/') }}" class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary-600 text-xs font-bold text-white">S</a>
                </div>
                <div class="flex-1"></div>

                {{-- Command Palette Trigger --}}
                <button x-data @click="$dispatch('open-command-palette')" class="hidden items-center gap-2 rounded-xl border border-primary-200 bg-white px-3 py-1.5 text-sm text-slate-400 transition hover:border-primary-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-500 sm:flex">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari...
                    <kbd class="rounded border border-slate-300 bg-white px-1.5 py-0.5 text-[10px] font-medium dark:border-slate-600 dark:bg-slate-700">Ctrl+K</kbd>
                </button>

                {{-- Dark Mode Toggle --}}
                <button x-data @click="dark = !dark; localStorage.theme = dark ? 'dark' : 'light'" class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800">
                    <svg x-show="!dark" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg x-show="dark" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>

                {{-- Notifikasi --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="relative flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($unreadCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white">{{ $unreadCount }}</span>
                        @endif
                    </button>
                    <div x-show="open" @click.outside="open = false" x-cloak x-transition class="absolute right-0 mt-2 w-80 rounded-2xl border border-primary-200 bg-white shadow-xl dark:border-slate-700 dark:bg-slate-800">
                        <div class="border-b border-primary-100 px-4 py-3 dark:border-slate-700">
                            <h4 class="text-sm font-semibold text-slate-900 dark:text-white">Notifikasi</h4>
                        </div>
                        <div class="max-h-80 overflow-y-auto p-2">
                            @forelse($user->notifications->take(5) as $notif)
                                <div class="rounded-xl px-3 py-2 transition hover:bg-slate-50 dark:hover:bg-slate-700/50 {{ is_null($notif->read_at) ? 'bg-primary-50/50 dark:bg-primary-900/10' : '' }}">
                                    <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $notif->title }}</p>
                                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">{{ $notif->message }}</p>
                                </div>
                            @empty
                                <p class="py-4 text-center text-sm text-slate-400">Tidak ada notifikasi</p>
                            @endforelse
                        </div>
                        <div class="border-t border-primary-100 px-4 py-2 dark:border-slate-700">
                            <a href="{{ route('notifikasi') }}" class="text-center text-xs font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">Lihat Semua</a>
                        </div>
                    </div>
                </div>

                {{-- User Dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 rounded-xl px-2 py-1 transition hover:bg-slate-100 dark:hover:bg-slate-800">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                        <span class="hidden text-sm font-medium text-slate-700 dark:text-slate-300 sm:block">{{ $user->name }}</span>
                        <svg class="hidden h-4 w-4 text-slate-400 sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-cloak x-transition class="absolute right-0 mt-2 w-56 rounded-2xl border border-primary-200 bg-white py-2 shadow-xl dark:border-slate-700 dark:bg-slate-800">
                        <div class="border-b border-primary-100 px-4 py-3 dark:border-slate-700">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                        </div>
                        <a href="{{ route('riwayat.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-700/50">Riwayat Saya</a>
                        @if($user->hasRole('mahasiswa'))
                            <a href="{{ route('denda.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-700/50">Denda Saya</a>
                        @endif
                        <div class="border-t border-primary-100 dark:border-slate-700"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/10">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- PAGE CONTENT --}}
            <main class="flex-1 p-4 pb-24 md:p-6 md:pb-6">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false }, 4000)" x-cloak x-transition class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
                        <div class="flex items-center justify-between">
                            <span>{{ session('success') }}</span>
                            <button @click="show = false" class="ml-2 text-emerald-500 hover:text-emerald-700">&times;</button>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-cloak x-transition class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">
                        {{ session('error') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Command Palette --}}
    <div x-data="commandPalette()" x-show="isOpen" x-cloak x-transition.opacity @open-command-palette.window="open()" @keydown.escape.window="close()" @keydown.ctrl.k.window.prevent="open()" @keydown.meta.k.window.prevent="open()" class="fixed inset-0 z-[100] flex items-start justify-center pt-[15vh]">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="close()"></div>
        <div class="relative w-full max-w-lg rounded-2xl border border-primary-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-900" @click.stop>
            <div class="flex items-center gap-3 border-b border-primary-100 px-4 dark:border-slate-700">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input x-ref="searchInput" x-model="query" @input="search()" type="text" placeholder="Cari menu, alat, pengguna..." class="flex-1 bg-transparent py-4 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none dark:text-white">
                <kbd class="rounded border border-slate-300 px-1.5 py-0.5 text-[10px] text-slate-400 dark:border-slate-600">ESC</kbd>
            </div>
            <div class="max-h-80 overflow-y-auto p-2">
                <template x-if="results.length === 0 && query.length > 0">
                    <p class="py-4 text-center text-sm text-slate-400">Tidak ditemukan</p>
                </template>
                <template x-for="item in results" :key="item.url">
                    <a :href="item.url" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-slate-800">
                        <span x-text="item.icon" class="text-lg"></span>
                        <div>
                            <p class="font-medium text-slate-900 dark:text-white" x-text="item.name"></p>
                            <p class="text-xs text-slate-500 dark:text-slate-400" x-text="item.description"></p>
                        </div>
                    </a>
                </template>
                <template x-if="query.length === 0">
                    <div>
                        <p class="px-3 py-1 text-xs font-medium text-slate-400">Menu Cepat</p>
                        <template x-for="item in menuItems" :key="item.url">
                            <a :href="item.url" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-slate-800">
                                <span x-text="item.icon" class="text-lg"></span>
                                <p class="font-medium text-slate-900 dark:text-white" x-text="item.name"></p>
                            </a>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function commandPalette() {
            return {
                isOpen: false,
                query: '',
                results: [],
                menuItems: [
                    { name: 'Dashboard', url: '{{ route("dashboard") }}', icon: '🏠', description: 'Halaman utama' },
                    { name: 'Katalog Alat', url: '{{ route("katalog.index") }}', icon: '📦', description: 'Lihat daftar alat' },
                    { name: 'Riwayat', url: '{{ route("riwayat.index") }}', icon: '📋', description: 'Riwayat peminjaman' },
                    @if($user->hasRole('mahasiswa'))
                    { name: 'Ajukan Pinjam', url: '{{ route("pinjam.create") }}', icon: '➕', description: 'Buat peminjaman baru' },
                    { name: 'Denda Saya', url: '{{ route("denda.index") }}', icon: '💰', description: 'Lihat denda' },
                    @endif
                    @if($user->hasRole('dosen'))
                    { name: 'Approval Mahasiswa', url: '{{ route("dosen.approval.index") }}', icon: '✅', description: 'Setujui peminjaman mahasiswa' },
                    @endif
                    @if($user->hasRole(['admin_lab', 'super_admin']))
                    { name: 'Scan QR', url: '{{ route("scan.index") }}', icon: '📷', description: 'Scan QR Code peminjaman' },
                    { name: 'Approval Admin', url: '{{ route("admin.approval.index") }}', icon: '🛡️', description: 'Konfirmasi peminjaman' },
                    { name: 'Kelola Alat', url: '{{ route("admin.alat.index") }}', icon: '⚙️', description: 'Manajemen alat' },
                    { name: 'Kelola Unit', url: '{{ route("admin.unit.index") }}', icon: '📦', description: 'Manajemen unit alat' },
                    { name: 'Pengembalian', url: '{{ route("admin.pengembalian.index") }}', icon: '🔄', description: 'Proses pengembalian' },
                    { name: 'Laporan', url: '{{ route("admin.laporan.index") }}', icon: '📊', description: 'Laporan peminjaman' },
                    @endif
                    @if($user->hasRole('super_admin'))
                    { name: 'Kelola User', url: '{{ route("super-admin.users.index") }}', icon: '👥', description: 'Manajemen pengguna' },
                    { name: 'Semua Pinjaman', url: '{{ route("super-admin.loans.index") }}', icon: '📋', description: 'Lihat semua pinjaman' },
                    { name: 'Kelola Denda', url: '{{ route("super-admin.fines.index") }}', icon: '💰', description: 'Manajemen denda' },
                    { name: 'Activity Log', url: '{{ route("super-admin.activity-log") }}', icon: '📝', description: 'Log aktivitas sistem' },
                    { name: 'Kategori', url: '{{ route("admin.kategori.index") }}', icon: '🏷️', description: 'Manajemen kategori' },
                    @endif
                ],
                open() {
                    this.isOpen = true;
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                },
                close() { this.isOpen = false; this.query = ''; this.results = []; },
                search() {
                    if (!this.query) { this.results = []; return; }
                    const q = this.query.toLowerCase();
                    this.results = this.menuItems.filter(i => i.name.toLowerCase().includes(q) || i.description.toLowerCase().includes(q));
                }
            }
        }
    </script>
</body>
</html>
