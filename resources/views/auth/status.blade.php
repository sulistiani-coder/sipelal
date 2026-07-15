<x-layouts.app>
    <div class="mx-auto w-full max-w-md rounded-2xl border border-slate-300 bg-slate-100 p-8 shadow-sm">
        <h1 class="mb-4 text-2xl font-semibold">Status Registrasi</h1>

        @if (session('status'))
            <div class="rounded-2xl bg-slate-100 p-4 text-slate-700">{{ session('status') }}</div>
        @else
            <div class="rounded-2xl bg-slate-100 p-4 text-slate-700">Silakan cek email Anda untuk instruksi selanjutnya.</div>
        @endif
    </div>
</x-layouts.app>
