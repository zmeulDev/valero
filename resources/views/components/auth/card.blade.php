<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="w-full max-w-6xl">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <!-- Logo/Branding Side -->
            <div class="hidden md:flex flex-col items-center justify-center p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl">
                <div class="w-full max-w-md">
                    {{ $logo }}
                    <div class="mt-8 space-y-4">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ __('frontend.auth.welcome_message') }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('frontend.auth.platform_description') }}
                        </p>
                        
                        <!-- Decorative Element -->
                        <div class="pt-8">
                            <img src="{{ asset('storage/brand/auth_background.png') }}" 
                                 alt="{{ __('frontend.auth.auth_image') }}" 
                                 class="w-full h-auto rounded-xl opacity-90"
                                 onerror="this.style.display='none'">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Side -->
            <div class="w-full">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 sm:p-10 border border-gray-200 dark:border-gray-700">
                    <!-- Mobile Logo -->
                    <div class="md:hidden flex justify-center mb-8">
                        {{ $logo }}
                    </div>

                    <!-- Form Content -->
                    {{ $slot }}
                </div>

                <!-- Footer Links -->
                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        {{ __('frontend.common.back_to_home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
