<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="user-cog"
            title="{{ __('Edit Team Member') }}"
            description="Update team member information and permissions"
            :breadcrumbs="[
                ['label' => 'Teams', 'url' => route('admin.teams.index')],
                ['label' => 'Edit Member']
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('admin.teams.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    Back to Team
                </a>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <!-- User Profile Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-md dark:border-gray-800" 
                                 src="{{ $user->profile_photo_url }}" 
                                 alt="{{ $user->name }}">
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400 space-y-1">
                                <div class="flex items-center">
                                    <x-lucide-calendar class="w-4 h-4 mr-2" />
                                    Member since {{ $user->created_at->format('M d, Y') }}
                                </div>
                                <div class="flex items-center">
                                    <x-lucide-clock class="w-4 h-4 mr-2" />
                                    Last login: {{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.teams.update', $user) }}" method="POST" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security & Role Section -->
<div class="p-6 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Security Card -->
        <div class="bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
            <div class="p-4 border-b border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Security</h4>
                    <x-lucide-lock class="w-4 h-4 text-gray-400" />
                </div>
            </div>
            <div class="p-4">
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Password
                            @if(isset($user))
                                <span class="text-gray-500 text-xs ml-1">(leave blank to keep current)</span>
                            @endif
                        </label>
                        <div class="mt-1 relative rounded-lg shadow-sm">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-white pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   {{ !isset($user) ? 'required' : '' }}>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <x-lucide-key class="h-5 w-5 text-gray-400" />
                            </div>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Role & Status Card -->
        <div class="bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
            <div class="p-4 border-b border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Role & Access</h4>
                    <x-lucide-shield class="w-4 h-4 text-gray-400" />
                </div>
            </div>
            <div class="p-4">
                <div class="space-y-4">
                    <!-- Role Select -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <select name="role" 
                                id="role" 
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                            <option value="user" {{ (isset($user) && old('role', $user->role) == 'user') || (!isset($user) && old('role') == 'user') ? 'selected' : '' }}>User</option>
                            <option value="editor" {{ (isset($user) && old('role', $user->role) == 'editor') || (!isset($user) && old('role') == 'editor') ? 'selected' : '' }}>Editor</option>
                            <option value="admin" {{ (isset($user) && old('role', $user->role) == 'admin') || (!isset($user) && old('role') == 'admin') ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status Toggle -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <div>
                            <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Account Status</label>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Allow user to access the system</p>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active"
                                   value="1" 
                                   {{ (isset($user) && old('is_active', $user->is_active)) || (!isset($user) && old('is_active', true)) ? 'checked' : '' }}
                                   class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 flex items-center justify-between">
                        <a href="{{ route('admin.teams.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <x-lucide-save class="w-4 h-4 mr-2" />
                            Update Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>