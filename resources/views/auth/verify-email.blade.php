<x-layouts.app>
    <div class="mx-auto w-full max-w-md rounded-2xl border border-slate-300 bg-slate-100 p-8 shadow-sm">
        <h1 class="mb-4 text-2xl font-semibold">Verifikasi Email</h1>

        @if (session('success'))
            <div class="mb-4 rounded-2xl bg-slate-100 p-4 text-slate-700">{{ session('success') }}</div>
        @endif

        <p class="text-sm text-slate-600">Silakan periksa email Anda dan klik link verifikasi untuk mengaktifkan akun.</p>

        <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
            @csrf
            <button type="submit" class="w-full rounded-xl bg-slate-300 px-5 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-400">Kirim Ulang Link Verifikasi</button>
        </form>
    </div>
</x-layouts.app>
