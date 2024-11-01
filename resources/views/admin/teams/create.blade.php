<x-admin-layout>
    <x-slot name="header">
        <div class="bg-white">
            <div class="border-b border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Left side -->
                        <div class="flex-1 flex items-center">
                            <x-lucide-user-plus class="w-8 h-8 text-indigo-600 mr-3" />
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 leading-7">
                                    {{ __('Add Team Member') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Add a new member to your team
                                </p>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.teams.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                                Back to Team
                            </a>
                        </div>
                    </div>

                    <!-- Breadcrumbs -->
                    <div class="py-4">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol role="list" class="flex items-center space-x-4">
                                <li>
                                    <div>
                                        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-gray-500">
                                            <x-lucide-home class="flex-shrink-0 h-5 w-5" />
                                            <span class="sr-only">Home</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <x-lucide-chevron-right class="flex-shrink-0 h-5 w-5 text-gray-400" />
                                        <a href="{{ route('admin.teams.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Team Management</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <x-lucide-chevron-right class="flex-shrink-0 h-5 w-5 text-gray-400" />
                                        <span class="ml-4 text-sm font-medium text-indigo-600">Add Member</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <!-- New Member Profile Header -->
                <div class="border-b border-gray-200 bg-gray-50 p-6">
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center">
                                <x-lucide-user-plus class="h-12 w-12 text-gray-400" />
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">New Team Member</h3>
                            <div class="mt-1 text-sm text-gray-500">
                                Fill in the information below to create a new team member account
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.teams.store') }}" method="POST">
                    @csrf
                    
                    <div class="p-8">
                        <!-- Basic Information Section -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <x-lucide-user class="w-5 h-5 mr-2 text-gray-500" />
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           value="{{ old('email') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <x-lucide-lock class="w-5 h-5 mr-2 text-gray-500" />
                                <h3 class="text-lg font-medium text-gray-900">Security</h3>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Role & Status Section -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <x-lucide-shield class="w-5 h-5 mr-2 text-gray-500" />
                                <h3 class="text-lg font-medium text-gray-900">Role & Status</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                    <select name="role" 
                                            id="role" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('role')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Active Account</span>
                                    </label>
                                    @error('is_active')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-8 py-4 bg-gray-50 flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.teams.index') }}" 
                           class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <x-lucide-user-plus class="w-4 h-4 mr-2" />
                            Create Team Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>