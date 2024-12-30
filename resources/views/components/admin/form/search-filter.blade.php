<form method="GET" class="flex items-center space-x-4">
    {{-- Search Input --}}
    <div class="relative">
        <input type="text" 
               name="search" 
               value="{{ request('search') }}"
               placeholder="{{ $searchPlaceholder }}" 
               class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <x-lucide-search class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" />
    </div>

    {{-- Filter Dropdown --}}
    @if(count($options) > 0)
        <select name="type" 
                class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                onchange="this.form.submit()">
            <option value="">{{ $filterLabel }}</option>
            @foreach($options as $value => $label)
                <option value="{{ $value }}" 
                        {{ request('type') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    @endif

    {{-- Clear Filters --}}
    @if(request()->hasAny(['search', 'type']))
        <a href="{{ url()->current() }}" 
           class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <x-lucide-x class="h-4 w-4 mr-1" />
            Clear
        </a>
    @endif
</form> 