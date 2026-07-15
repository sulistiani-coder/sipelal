<x-layouts.app title="Notifikasi">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Notifikasi</h1>
            </div>
            <form method="POST" action="{{ route('notifikasi.read-all') }}">
                @csrf
                <button class="rounded-xl bg-primary-100 px-4 py-2 text-sm font-medium text-primary-700 transition hover:bg-primary-200 dark:bg-primary-900/30 dark:text-primary-400">Tandai semua dibaca</button>
            </form>
        </div>

        <div class="rounded-2xl border border-primary-100 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                @forelse($notifications as $notif)
                <div class="px-6 py-4 transition hover:bg-primary-50 dark:hover:bg-slate-700/30 {{ is_null($notif->read_at) ? 'bg-primary-50/30 dark:bg-primary-900/5' : '' }}">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ is_null($notif->read_at) ? 'bg-primary-100 dark:bg-primary-900/30' : 'bg-slate-100 dark:bg-slate-700' }}">
                            <svg class="h-4 w-4 {{ is_null($notif->read_at) ? 'text-primary-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $notif->title }}</p>
                            <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400">{{ $notif->message }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $notif->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada notifikasi</div>
                @endforelse
            </div>
            <div class="border-t border-primary-100 px-6 py-3 dark:border-slate-700">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
