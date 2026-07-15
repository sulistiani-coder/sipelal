@props([
    'icon' => 'inbox',
    'title' => 'Belum ada data',
    'description' => '',
    'action' => null,
    'actionUrl' => null,
])

<div class="flex flex-col items-center justify-center py-12 text-center">
    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700">
        <x-dynamic-component component="lucide-{{ $icon }}" class="h-8 w-8 text-slate-400 dark:text-slate-500" />
    </div>
    <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
    @if($description)
        <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
    @endif
    @if($action && $actionUrl)
        <a href="{{ $actionUrl }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-700">
            {{ $action }}
        </a>
    @endif
</div>
