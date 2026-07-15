<x-layouts.app title="Scan QR Code">
    <div class="space-y-6" x-data="qrScanner()">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Scan QR Code Peminjaman</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Arahkan kamera ke QR Code pada kartu peminjaman</p>
        </div>

        @if(session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-2xl border border-primary-100 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
            {{-- Scanner Area --}}
            <div class="relative mx-auto max-w-md overflow-hidden rounded-xl bg-slate-900" style="aspect-ratio: 1;">
                <div id="qr-reader" class="h-full w-full"></div>
                <div class="pointer-events-none absolute inset-0 flex items-center justify-center">
                    <div class="h-48 w-48 rounded-2xl border-2 border-dashed border-emerald-400/60"></div>
                </div>
            </div>

            {{-- Status --}}
            <div class="mt-4 text-center">
                <template x-if="status === 'scanning'">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        <svg class="mr-1 inline h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Menunggu scan...
                    </p>
                </template>
                <template x-if="status === 'found'">
                    <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Peminjaman ditemukan! Mengarahkan...</p>
                </template>
                <template x-if="status === 'error'">
                    <p class="text-sm text-red-500" x-text="errorMsg"></p>
                </template>
            </div>

            {{-- Manual Input --}}
            <div class="mt-6 border-t border-primary-100 pt-6 dark:border-slate-700">
                <form method="POST" action="{{ route('scan.process') }}" class="flex gap-3">
                    @csrf
                    <input type="text" name="uuid" placeholder="Atau masukkan UUID manual..." required class="flex-1 rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    <button type="submit" class="rounded-xl bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700">Cari</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        function qrScanner() {
            return {
                status: 'scanning',
                errorMsg: '',
                scanner: null,
                init() {
                    var self = this;
                    self.scanner = new Html5QrcodeScanner('qr-reader', {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    });

                    self.scanner.render(
                        function(decodedText) {
                            self.status = 'found';
                            self.scanner.clear();
                            window.location.href = '{{ url("scan") }}/' + decodedText;
                        },
                        function(errorMessage) {}
                    );
                },
                destroy() {
                    if (this.scanner) this.scanner.clear();
                }
            }
        }
    </script>
</x-layouts.app>
