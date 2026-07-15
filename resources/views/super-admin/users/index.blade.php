<x-layouts.app title="Kelola User">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Kelola User</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola semua akun pengguna sistem</p>
            </div>
            <a href="{{ route('super-admin.users.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah User
            </a>
        </div>

        <form method="GET" class="rounded-2xl border border-primary-100 bg-white p-4 dark:border-slate-700 dark:bg-slate-800">
            <div class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, NIM..." class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                </div>
                <div>
                    <select name="role" class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        <option value="">Semua Role</option>
                        <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin_lab" {{ request('role') === 'admin_lab' ? 'selected' : '' }}>Admin Lab</option>
                        <option value="dosen" {{ request('role') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="mahasiswa" {{ request('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    </select>
                </div>
                <div>
                    <select name="status" class="rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-primary-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="ACTIVE" {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>Aktif</option>
                        <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>Pending</option>
                        <option value="SUSPENDED" {{ request('status') === 'SUSPENDED' ? 'selected' : '' }}>Ditangguhkan</option>
                    </select>
                </div>
                <button type="submit" class="rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700">Filter</button>
                @if(request()->hasAny(['search', 'role', 'status']))
                    <a href="{{ route('super-admin.users.index') }}" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-50 dark:border-slate-600 dark:text-slate-300">Reset</a>
                @endif
            </div>
        </form>

        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-primary-100 dark:border-slate-700">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Lab</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">NIM</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($users as $user)
                        <tr class="transition hover:bg-primary-50 dark:hover:bg-slate-700/30">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                    <div>
                                        <p class="font-medium text-slate-900 dark:text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php($roleColors = ['super_admin' => 'purple', 'admin_lab' => 'blue', 'dosen' => 'orange', 'mahasiswa' => 'green'])
                                <x-badge-status :status="$user->getRoleNames()->first() ?? 'mahasiswa'" :label="ucfirst(str_replace('_', ' ', $user->getRoleNames()->first() ?? 'mahasiswa'))" />
                            </td>
                            <td class="px-6 py-4"><x-badge-status :status="$user->status" /></td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $user->lab->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $user->nim ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('super-admin.users.toggle-status', $user) }}">
                                            @csrf
                                            <button class="rounded-lg {{ $user->status === 'ACTIVE' ? 'bg-amber-100 text-amber-700 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' }} px-3 py-1.5 text-xs font-semibold transition">
                                                {{ $user->status === 'ACTIVE' ? 'Suspend' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('super-admin.users.edit', $user) }}" class="rounded-lg bg-primary-100 px-3 py-1.5 text-xs font-semibold text-primary-700 transition hover:bg-primary-200 dark:bg-primary-900/30 dark:text-primary-400">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('super-admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf @method('DELETE')
                                            <button class="rounded-lg bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada user ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-primary-100 px-6 py-3 dark:border-slate-700">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
