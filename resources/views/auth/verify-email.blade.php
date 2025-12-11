<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <x-auth.logo />
        </x-slot>

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ __('frontend.auth.verify_email') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('frontend.auth.verify_email_description') }}
            </p>
        </div>

        <!-- Success Message -->
        @if (session('status') === 'verification-link-sent')
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <p class="text-sm font-medium text-green-600 dark:text-green-400">
                        {{ __('frontend.auth.verification_link_sent') }}
                    </p>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="space-y-4">
            <!-- Resend Verification Email -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <x-button 
                    type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    {{ __('frontend.auth.resend_verification_email') }}
                </x-button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button 
                    type="submit" 
                    class="w-full px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    {{ __('frontend.auth.log_out') }}
                </button>
            </form>
        </div>
    </x-auth.card>
</x-guest-layout>
