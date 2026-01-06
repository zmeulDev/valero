@props(['articles'])

@if($articles->count() > 0)
    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden ring-1 ring-black ring-opacity-5">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('admin.common.title') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('admin.common.category') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('admin.common.status') }}
                        </th>
                        <th scope="col" class="relative px-6 py-3.5">
                            <span class="sr-only">{{ __('admin.common.actions') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($articles as $article)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 relative">
                                        @if($article->media->firstWhere('is_cover', true)->image_path ?? false)
                                            <img src="{{ asset('storage/' . $article->media->firstWhere('is_cover', true)->image_path) }}"
                                                alt="{{ $article->title }}"
                                                class="h-10 w-10 rounded-lg object-cover ring-2 ring-gray-100 dark:ring-gray-700 group-hover:ring-indigo-500/50 dark:group-hover:ring-indigo-400/50 transition-all">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center ring-2 ring-gray-100 dark:ring-gray-700">
                                                <x-lucide-image class="h-5 w-5 text-gray-400" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4 min-w-0 flex-1">
                                        <div
                                            class="text-sm font-medium text-gray-900 dark:text-white line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                            {{ $article->title }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            {{ __('admin.articles.by') }} <span
                                                class="text-gray-700 dark:text-gray-300">{{ $article->user->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->category ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $article->category?->name ?? __('admin.articles.uncategorized') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($article->scheduled_at && $article->scheduled_at->isFuture())
                                    <div class="flex flex-col">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20 w-fit">
                                            <x-lucide-clock class="w-3 h-3 mr-1" />
                                            {{ __('admin.status.scheduled') }}
                                        </span>
                                        <span class="text-xs text-gray-400 mt-1 pl-1">
                                            {{ $article->scheduled_at->format('M j, Y H:i') }}
                                        </span>
                                    </div>
                                @else
                                    <div class="flex flex-col">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-inset ring-green-600/20 w-fit">
                                            <x-lucide-check-circle class="w-3 h-3 mr-1" />
                                            {{ __('admin.status.published') }}
                                        </span>
                                        <span class="text-xs text-gray-400 mt-1 pl-1">
                                            {{ $article->created_at->format('M j, Y') }}
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-2">
                                    <a href="{{ route('admin.articles.show', $article) }}"
                                        class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors p-1"
                                        title="{{ __('admin.common.view') }}">
                                        <x-lucide-eye class="h-5 w-5" />
                                    </a>
                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                        class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors p-1"
                                        title="{{ __('admin.common.edit') }}">
                                        <x-lucide-pencil class="h-5 w-5" />
                                    </a>
                                    <button @click="openDeleteModal({{ $article->id }})"
                                        class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors p-1"
                                        title="{{ __('admin.common.delete') }}">
                                        <x-lucide-trash class="h-5 w-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <x-nothing-found />
@endif

<!-- Pagination -->
<div class="mt-6">
    {{ $articles->links() }}
</div>