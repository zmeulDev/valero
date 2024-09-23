<!-- Search Form with Category Filter -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 p-6">
  <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
    Search Articles
  </h3>
  <form action="{{ route('search') }}" method="GET">
    <input type="text" name="query" placeholder="Search..." required
      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">

    <!-- Category Dropdown -->
    <select name="category"
      class="w-full mt-4 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
      <option value="">All Categories</option>
      @foreach($categories as $category)
      <option value="{{ $category->id }}">{{ $category->name }}</option>
      @endforeach
    </select>

    <button type="submit"
      class="mt-4 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
      Search
    </button>
  </form>
</div>