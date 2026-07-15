@props(['title' => null, 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800']) }}>
    @if($title || $description)
        <div class="mb-4">
            @if($title)
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
