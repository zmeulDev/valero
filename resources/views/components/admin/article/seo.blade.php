@props(['article'])

<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
     x-data="{ isOpen: localStorage.getItem('seo-expanded') === 'true' }"
     x-init="$watch('isOpen', value => localStorage.setItem('seo-expanded', value))">
    <!-- Header -->
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center cursor-pointer"
         @click.prevent.stop="isOpen = !isOpen">
        <div class="flex items-center gap-2">
            <x-lucide-search class="w-5 h-5 text-indigo-500" />
            <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    SEO Information
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    Search engine optimization details
                </p>
            </div>
        </div>
        <button type="button" 
                @click.prevent.stop="isOpen = !isOpen"
                class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200"
                :class="{ 'rotate-180': isOpen }">
            <x-lucide-chevron-down class="w-5 h-5" />
        </button>
    </div>

    <!-- Content -->
    <div class="border-t border-gray-200 dark:border-gray-700"
         x-show="isOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2">
        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Title
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    {{ $article->seo->title ?? 'Not set' }}
                </dd>
            </div>

            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Description
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    {{ $article->seo->description ?? 'Not set' }}
                </dd>
            </div>

            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Image
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    <img src="{{ $article && $article->seo && $article->seo->image ? asset('storage/' . $article->seo->image) : asset('storage/brand/logo.png') }}"
                         alt="SEO Image"
                         class="w-32 h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                </dd>
            </div>

            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Author
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    {{ $article->seo->author ?? 'Not set' }}
                </dd>
            </div>

            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Robots
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    {{ $article->seo->robots ?? 'Not set' }}
                </dd>
            </div>

            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Canonical URL
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2 break-all">
                    {{ $article->seo->canonical_url ?? 'Not set' }}
                </dd>
            </div>
        </dl>
    </div>
</div>