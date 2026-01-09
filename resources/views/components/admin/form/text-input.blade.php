@props([
    'name',
    'label',
    'value' => '',
    'type' => 'text',
    'required' => false,
    'placeholder' => ''
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-text">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <input 
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-lg border-border bg-background text-text shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder-muted']) }}>
    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
