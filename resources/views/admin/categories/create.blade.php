<x-admin-layout>
    <x-slot name="title">Add Category</x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Create New Category</h2>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
                @csrf

                <!-- Category Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input type="text" name="name" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" placeholder="Enter category name" required>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end">
                    <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-md shadow-sm transition duration-150 ease-in-out mr-2">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow-sm transition duration-150 ease-in-out inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
