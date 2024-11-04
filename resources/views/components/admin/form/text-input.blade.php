@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'maxlength' => null,
    'type' => 'text',
    'placeholder' => '',
    'rows' => null
])

<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-6">
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>

        @if($rows)
            <textarea
                id="{{ $name }}"
                name="{{ $name }}"
                rows="{{ $rows }}"
                :placeholder="$placeholder"
                x-data="{ charCount: $el.value.length }"
                x-on:input="charCount = $el.value.length"
                {{ $maxlength ? "maxlength=$maxlength" : '' }}
                {{ $required ? 'required' : '' }}
                {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white']) }}
            >{{ $value }}</textarea>
        @else
            <input
                type="{{ $type }}"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ $value }}"
                placeholder="{{ $placeholder }}"
                x-data="{ charCount: $el.value.length }"
                x-on:input="charCount = $el.value.length"
                {{ $maxlength ? "maxlength=$maxlength" : '' }}
                {{ $required ? 'required' : '' }}
                {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white']) }}
            >
        @endif

        @if($maxlength)
            <div class="mt-2 flex items-center justify-between text-sm">
                <p class="text-gray-500 dark:text-gray-400">Recommended: {{ $maxlength }} characters maximum</p>
                <p x-text="charCount + '/{{ $maxlength }}'"
                   :class="{ 'text-red-500': charCount > {{ $maxlength }}, 'text-gray-500': charCount <= {{ $maxlength }} }"
                   class="dark:text-gray-400"></p>
            </div>
        @endif
    </div>
</div>
