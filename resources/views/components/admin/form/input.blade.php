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

<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-4">
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
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
                {{ $attributes->merge(['class' => 'block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm' . ($prefix ? ' pl-10' : '') . ($suffix ? ' pr-10' : '')]) }}
            >

            @if($suffix)
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    {{ $suffix }}
                </div>
            @endif
        </div>

        @if($help)
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $help }}</p>
        @endif

        @error($name)
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>