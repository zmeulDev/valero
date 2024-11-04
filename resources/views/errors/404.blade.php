<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-gray-900 dark:text-white">404</h1>
            <p class="mt-4 text-gray-600 dark:text-gray-400">Page not found</p>
            <a href="{{ route('home') }}" class="mt-6 inline-flex items-center text-indigo-600 hover:text-indigo-500">
                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                Back to Home
            </a>
        </div>
    </div>
</x-guest-layout> 