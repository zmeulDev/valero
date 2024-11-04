@props([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'required' => false,
    'help' => null
])

<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-4">
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>

        <select
            name="{{ $name }}"
            id="{{ $name }}"
            @if($required) required @endif
            {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm']) }}
        >
            @foreach($options as $value => $label)
                <option value="{{ $value }}" @selected($value == $selected)>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @if($help)
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $help }}</p>
        @endif

        @error($name)
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>