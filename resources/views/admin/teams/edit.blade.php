<x-admin-layout>
    <x-slot name="header">
        <div class="bg-white">
            <div class="border-b border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Left side -->
                        <div class="flex-1 flex items-center">
                            <x-lucide-user-cog class="w-8 h-8 text-indigo-600 mr-3" />
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 leading-7">
                                    {{ __('Edit Team Member') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Update team member information and permissions
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
                                        <span class="ml-4 text-sm font-medium text-indigo-600">Edit Member</span>
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
                <!-- User Profile Header -->
                <div class="border-b border-gray-200 bg-gray-50 p-6">
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow" 
                                 src="{{ $user->profile_photo_url }}" 
                                 alt="{{ $user->name }}">
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <div class="mt-1 text-sm text-gray-500 space-y-1">
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

                <form action="{{ route('admin.teams.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
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
                                           value="{{ old('name', $user->name) }}" 
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
                                           value="{{ old('email', $user->email) }}" 
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
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Password
                                    <span class="text-gray-500 text-xs">(leave blank to keep current)</span>
                                </label>
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
                                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('role')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" 
                                               name="is_active" 
                                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}
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
                    <div class="px-8 py-4 bg-gray-50 flex items-center justify-between">
                        <!-- Delete Button -->
                        @if($user->id !== auth()->id())
                            <button type="button" 
                                    onclick="window.confirmDelete.showModal()"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <x-lucide-trash-2 class="w-4 h-4 mr-2" />
                                Delete Member
                            </button>
                        @else
                            <div></div>
                        @endif

                        <!-- Save/Cancel Buttons -->
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.teams.index') }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <x-lucide-check class="w-4 h-4 mr-2" />
                                Update Team Member
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <dialog id="confirmDelete" 
            class="rounded-lg shadow-xl p-0 w-full max-w-lg mx-auto overflow-hidden">
        <div class="bg-white px-6 py-4">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <h3 class="text-lg font-semibold text-gray-900">Confirm Deletion</h3>
                <button type="button" 
                        onclick="window.confirmDelete.close()"
                        class="text-gray-400 hover:text-gray-500">
                    <x-lucide-x class="w-5 h-5" />
                </button>
            </div>

            <div class="py-4">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="h-12 w-12 rounded-full" 
                             src="{{ $user->profile_photo_url }}" 
                             alt="{{ $user->name }}">
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to delete this team member? This action cannot be undone.
                        All of their data will be permanently removed from the system.
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <button type="button"
                        onclick="window.confirmDelete.close()"
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
                <form action="{{ route('admin.teams.destroy', $user) }}" 
                      method="POST" 
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                        <x-lucide-trash-2 class="w-4 h-4 mr-2" />
                        Delete Member
                    </button>
                </form>
            </div>
        </div>
    </dialog>

    <!-- Modal Backdrop -->
    <div id="modalBackdrop" 
         class="fixed inset-0 bg-black bg-opacity-50 hidden"
         onclick="window.confirmDelete.close()">
    </div>

    <!-- Modal Script -->
    <script>
        const modal = document.getElementById('confirmDelete');
        const backdrop = document.getElementById('modalBackdrop');

        modal.addEventListener('close', () => {
            backdrop.classList.add('hidden');
        });

        window.confirmDelete = {
            showModal() {
                modal.showModal();
                backdrop.classList.remove('hidden');
            },
            close() {
                modal.close();
            }
        };
    </script>
</x-admin-layout>
