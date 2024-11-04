@props([
    'name',
    'label',
    'currentImage' => null,
    'accept' => 'image/*',
    'required' => false,
])

<div>
    @if($label ?? null)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
        </label>
    @endif

    <div class="mt-2 flex items-center space-x-4">
        @if($currentImage)
            <div class="flex-shrink-0 h-12 w-12">
                <img class="h-12 w-12 rounded-full object-cover" src="{{ $currentImage }}" alt="Current image">
            </div>
        @endif

        <div class="flex items-center">
            <input type="file" 
                   id="{{ $name }}" 
                   name="{{ $name }}"
                   accept="{{ $accept }}"
                   {{ $required ? 'required' : '' }}
                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-md file:border-0
                          file:text-sm file:font-medium
                          file:bg-indigo-50 file:text-indigo-700
                          hover:file:bg-indigo-100
                          dark:file:bg-indigo-900/50 dark:file:text-indigo-400
                          dark:hover:file:bg-indigo-900/75">
        </div>
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>