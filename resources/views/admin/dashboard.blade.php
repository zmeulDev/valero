<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="layout-dashboard"
            title="{{ __('Dashboard') }}"
            description="Overview of your site's performance and content"
        >
            <x-slot:actions>
                <span class="text-sm text-gray-500">v.{{ config('app.version') }}</span>
                <a href="{{ route('admin.articles.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-lucide-plus-circle class="w-4 h-4 mr-2" />
                    New Article
                </a>
            </x-slot:actions>

            <x-slot:stats>
                <x-admin.stats-card
                    icon="book-open"
                    label="Total Articles"
                    :value="$articleCount"
                />
                <x-admin.stats-card
                    icon="eye"
                    iconColor="blue"
                    label="Total Views"
                    :value="$totalViews"
                />
                <x-admin.stats-card
                    icon="users"
                    iconColor="green"
                    label="Active Users (last 7 days)"
                    :value="$activeUsers"
                />
                <x-admin.stats-card
                    icon="trending-up"
                    iconColor="purple"
                    label="Avg. Views/Article"
                    :value="$articleCount ? round($totalViews / $articleCount, 1) : 0"
                />
            </x-slot:stats>
        </x-admin.page-header>
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