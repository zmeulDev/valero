@props([
    'header' => null,
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden']) }}>
    @if($header)
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            {{ $header }}
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $footer }}
        </div>
    @endif
</div>