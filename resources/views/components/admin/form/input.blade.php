@props([
    'name',
    'label',
    'value' => '',
    'type' => 'text',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'help' => null,
    'error' => null,
    'prefix' => null,
    'suffix' => null
])

<div class="bg-surface shadow-sm rounded-lg overflow-hidden border border-border">
    <div class="p-4">
        <label for="{{ $name }}" class="block text-sm font-medium text-text mb-1">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>

        <div class="mt-1 relative rounded-md shadow-sm">
            @if($prefix)
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    {{ $prefix }}
                </div>
            @endif

            <input 
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $name }}"
                value="{{ $value }}"
                @if($required) required @endif
                @if($disabled) disabled @endif
                @if($readonly) readonly @endif
                {{ $attributes->merge(['class' => 'block w-full rounded-md border-border bg-background text-text focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm' . ($prefix ? ' pl-10' : '') . ($suffix ? ' pr-10' : '')]) }}
            >

            @if($suffix)
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    {{ $suffix }}
                </div>
            @endif
        </div>

        @if($help)
            <p class="mt-2 text-sm text-muted">{{ $help }}</p>
        @endif

        @error($name)
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>