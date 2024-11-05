@props([
    'name',
    'label',
    'currentImage' => null,
    'required' => false,
    'accept' => 'image/*'
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <div class="mt-2 flex items-center space-x-4">
        @if($currentImage)
            <div class="flex-shrink-0 h-12 w-12">
                <img class="h-12 w-12 rounded-lg object-cover" src="{{ $currentImage }}" alt="Current image">
            </div>
        @endif

        <input type="file" 
               id="{{ $name }}" 
               name="{{ $name }}"
               accept="{{ $accept }}"
               {{ $required ? 'required' : '' }}
               {{ $attributes->merge(['class' => 'block w-full text-sm text-gray-500 dark:text-gray-400
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-md file:border-0
                      file:text-sm file:font-medium
                      file:bg-indigo-50 file:text-indigo-700
                      hover:file:bg-indigo-100
                      dark:file:bg-indigo-900/50 dark:file:text-indigo-400
                      dark:hover:file:bg-indigo-900/75']) }}>
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>