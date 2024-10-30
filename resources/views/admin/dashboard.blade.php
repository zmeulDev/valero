<x-admin-layout>
    <x-slot name="header">
        <div class="bg-white">
            <div class="border-b border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Left side -->
                        <div class="flex-1 flex items-center">
                            <x-lucide-layout-dashboard class="w-8 h-8 text-indigo-600 mr-3" />
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 leading-7">
                                    {{ __('Dashboard') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Overview of your site's performance and content
                                </p>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500">v.{{ config('app.version') }}</span>
                            <a href="{{ route('admin.articles.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <x-lucide-plus-circle class="w-4 h-4 mr-2" />
                                New Article
                            </a>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 py-4">
                        <!-- Total Articles -->
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                                    <x-lucide-book-open class="h-6 w-6 text-indigo-600" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Total Articles</div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $articleCount }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Users -->
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                    <x-lucide-users class="h-6 w-6 text-green-600" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Total Users</div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $userCount }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Views -->
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                    <x-lucide-eye class="h-6 w-6 text-blue-600" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Total Views</div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $totalViews }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Average Views -->
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                    <x-lucide-trending-up class="h-6 w-6 text-purple-600" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Avg. Views/Article</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ $articleCount ? round($totalViews / $articleCount, 1) : 0 }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Latest Articles Section -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Latest Articles</h2>
                        <a href="{{ route('admin.articles.index') }}" 
                           class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                            View All
                            <x-lucide-chevron-right class="w-4 h-4 ml-1" />
                        </a>
                    </div>

                    @if ($articles->isEmpty())
                        <x-nothing-found />
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($articles as $article)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($article->featured_image)
                                                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                                         alt="{{ $article->title }}"
                                                         class="h-10 w-10 rounded-lg object-cover">
                                                @else
                                                    <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                        <x-lucide-image class="h-6 w-6 text-gray-400" />
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                    {{ $article->category->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $article->title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $article->user->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">
                                                    {{ $article->created_at->format('M d, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.articles.edit', $article->id) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $articles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>