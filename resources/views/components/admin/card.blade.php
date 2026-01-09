@props([
    'header' => null,
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'bg-surface shadow-sm rounded-lg overflow-hidden']) }}>
    @if($header)
        <div class="px-6 py-4 border-b border-border">
            {{ $header }}
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 border-t border-border">
            {{ $footer }}
        </div>
    @endif
</div>