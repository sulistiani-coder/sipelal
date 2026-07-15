<x-layouts.app title="Pengembalian">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Pengembalian Alat</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Proses pengembalian alat yang sedang dipinjam</p>
        </div>

        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-primary-100 dark:border-slate-700">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Alat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($loans as $loan)
                        @php
                            $isOverdue = $loan->tgl_kembali_rencana->isPast();
                        @endphp
                        <tr class="transition hover:bg-primary-50 dark:hover:bg-slate-700/30 {{ $isOverdue ? 'bg-red-50/50 dark:bg-red-900/5' : '' }}">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $loan->kode_pinjam }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $loan->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                @foreach($loan->loanItems as $item)
                                    {{ $item->equipmentUnit->equipment->name ?? '-' }}@if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-xs {{ $isOverdue ? 'font-bold text-red-600' : 'text-slate-500' }}">
                                {{ $loan->tgl_kembali_rencana?->format('d M Y') }}
                                @if($isOverdue)
                                    <br><span class="text-red-500">TERLAMBAT {{ $loan->tgl_kembali_rencana->diffInDays(now()) }} hari</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button onclick="document.getElementById('return-{{ $loan->id }}').classList.toggle('hidden')" class="rounded-lg bg-primary-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-primary-700">Proses</button>
                            </td>
                        </tr>
                        <tr id="return-{{ $loan->id }}" class="hidden">
                            <td colspan="5" class="bg-slate-50 px-6 py-4 dark:bg-slate-900">
                                <form method="POST" action="{{ route('admin.pengembalian.store', $loan) }}" class="space-y-3">
                                    @csrf
                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <div>
                                            <label class="mb-1 block text-xs font-medium text-slate-700 dark:text-slate-300">Tanggal Kembali Aktual *</label>
                                            <input type="date" name="tgl_kembali_aktual" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-xs font-medium text-slate-700 dark:text-slate-300">Catatan</label>
                                            <input type="text" name="catatan" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white" placeholder="Catatan pengembalian">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-slate-700 dark:text-slate-300">Kondisi per Unit *</label>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($loan->loanItems as $idx => $item)
                                                <select name="kondisi_kembali[{{ $idx }}]" required class="rounded-lg border border-slate-300 px-2 py-1.5 text-xs dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                                    <option value="BAIK">Baik</option>
                                                    <option value="PERLU_PERHATIAN">Perlu Perhatian</option>
                                                    <option value="RUSAK_RINGAN">Rusak Ringan</option>
                                                    <option value="RUSAK_BERAT">Rusak Berat</option>
                                                </select>
                                            @endforeach
                                        </div>
                                    </div>
                                    <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">Simpan Pengembalian</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada alat yang perlu dikembalikan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
