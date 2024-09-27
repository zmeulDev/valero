<!-- Search Form with Category Filter -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 p-6">
  <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
    Search Articles
  </h3>
  <form action="{{ route('search') }}" method="GET">
    <x-input type="text" name="query" placeholder="Search..." required class="w-full mb-4" />

    <!-- Category Dropdown
    <div class="mb-4">
      <x-dropdown align="top" width="full">
        <x-slot name="trigger">
          <x-button type="button" class="w-full justify-between">
            <span
              x-text="$refs.categorySelect.value ? $refs.categorySelect.options[$refs.categorySelect.selectedIndex].text : 'All Categories'">
              All Categories
            </span>
            <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </x-button>
        </x-slot>

        <x-slot name="content">
          <div class="max-h-60 overflow-y-auto">
            <x-dropdown-link href="#"
              @click.prevent="$refs.categorySelect.value = ''; $refs.categorySelect.dispatchEvent(new Event('change'))">
              All Categories
            </x-dropdown-link>
            @foreach($categories as $category)
            <x-dropdown-link href="#"
              @click.prevent="$refs.categorySelect.value = '{{ $category->id }}'; $refs.categorySelect.dispatchEvent(new Event('change'))">
              {{ $category->name }}
            </x-dropdown-link>
            @endforeach
          </div>
        </x-slot>
      </x-dropdown>

      <select name="category" x-ref="categorySelect" class="hidden">
        <option value="">All Categories</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
    </div>
    -->
    <x-button type="submit" class="w-full">
      Search
    </x-button>
  </form>
</div>