<x-admin-layout>
    <x-slot name="title">Add Category</x-slot>

    <h1 class="text-4xl font-semibold mb-6">Create Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <!-- Category Name -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Category Name</label>
            <input type="text" name="name" class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200" placeholder="Enter category name" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 transition ease-in-out duration-150">
            Create Category
        </button>
    </form>
</x-admin-layout>
