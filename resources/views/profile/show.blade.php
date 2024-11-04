<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="user"
            title="{{ __('Profile Settings') }}"
            description="Manage your account settings and security preferences"
        >
            <x-slot:actions>
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    Back to Dashboard
                </a>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Left Sidebar -->
                <div class="w-full lg:w-1/3 space-y-6">
                    <!-- Profile Overview Card -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col items-center text-center">
                                <div class="relative">
                                    <img class="h-24 w-24 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-md" 
                                         src="{{ auth()->user()->profile_photo_url }}" 
                                         alt="{{ auth()->user()->name }}" />
                                    <div class="absolute bottom-0 right-0 h-6 w-6 rounded-full bg-green-500 border-2 border-white dark:border-gray-700"></div>
                                </div>
                                <h2 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">
                                    {{ auth()->user()->name }}
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                                
                                <div class="mt-4 grid grid-cols-2 gap-4 w-full">
                                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</div>
                                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ ucfirst(auth()->user()->role) }}
                                        </div>
                                    </div>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</div>
                                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ auth()->user()->created_at->format('M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Two Factor Authentication -->
                    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                        @livewire('profile.two-factor-authentication-form')
                    @endif
                </div>

                <!-- Right Content -->
                <div class="w-full lg:w-2/3 space-y-6">
                    <!-- Profile Information -->
                    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                        @livewire('profile.update-profile-information-form')
                    @endif

                    <!-- Update Password -->
                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                        @livewire('profile.update-password-form')
                    @endif

                    <!-- Browser Sessions -->
                    @livewire('profile.logout-other-browser-sessions-form')

                    <!-- Delete Account -->
                    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                        @livewire('profile.delete-user-form')
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
