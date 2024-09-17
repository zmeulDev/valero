<x-admin-layout>
    <x-slot name="title">Add category</x-slot>
    <h1 class="text-3xl font-bold mb-6">Create Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-bold mb-2">Category Name</label>
            <input type="text" name="name" class="w-full p-2 border" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create Category</button>
    </form>
</x-admin-layout>

