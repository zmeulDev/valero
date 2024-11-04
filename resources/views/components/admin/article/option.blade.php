@props(['categories', 'article'])

<div class="bg-white shadow-md rounded-lg overflow-hidden">
  <div class="p-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
    <select name="category_id"
      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      required>
      <option value="">Select Category</option>
      @foreach ($categories as $category)
      <option value="{{ $category->id }}"
        {{ old('category_id', $article?->category_id) == $category->id ? 'selected' : '' }}>
        {{ $category->name }}
      </option>
      @endforeach
    </select>
  </div>
  <div class="p-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Scheduled Publish Date</label>
    <input type="datetime-local" name="scheduled_at"
      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      value="{{ old('scheduled_at', $article?->scheduled_at ? $article->scheduled_at : now()) }}">
  </div>
</div>
