@props([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'required' => false,
    'help' => null
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-text">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-lg border-border bg-background text-text shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm']) }}
    >
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>

    @if($help)
        <p class="mt-2 text-sm text-muted">{{ $help }}</p>
    @endif

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>