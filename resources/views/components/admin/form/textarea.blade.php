@props([
    'name',
    'label',
    'value' => '',
    'rows' => 3,
    'placeholder' => '',
    'required' => false
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-text">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}" 
        rows="{{ $rows }}" 
        class="mt-1 block w-full rounded-lg border-border bg-background text-text shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder-muted"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}>{{ $value }}</textarea>
    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>