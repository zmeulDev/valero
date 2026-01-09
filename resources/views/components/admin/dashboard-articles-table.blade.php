@props(['articles'])

@if ($articles->isEmpty())
    <x-nothing-found />
@else
    <div class="overflow-x-auto ring-1 ring-black ring-opacity-5 rounded-lg border border-border">
        <table class="min-w-full divide-y divide-border">
            <thead class="bg-background">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">
                        {{ __('admin.common.title') }}
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">
                        {{ __('admin.dashboard.author') }}
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">
                        {{ __('admin.dashboard.status') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-surface divide-y divide-border">
                @foreach ($articles as $article)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 relative">
                                    @if($article->media->firstWhere('is_cover', true)->image_path ?? false)
                                        <img class="h-10 w-10 rounded-lg object-cover ring-2 ring-border group-hover:ring-indigo-500/50 transition-all" 
                                             src="{{ asset('storage/' . $article->media->firstWhere('is_cover', true)->image_path) }}" 
                                             alt="">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-background flex items-center justify-center ring-2 ring-border">
                                            <x-lucide-image class="h-5 w-5 text-muted" />
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 min-w-0">
                                    <div class="text-sm font-medium text-text line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $article->title }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-text">{{ $article->user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($article->scheduled_at && $article->scheduled_at->isFuture())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20">
                                    <x-lucide-clock class="w-3 h-3 mr-1" />
                                    {{ __('admin.status.scheduled') }}
                                </span>
                                <div class="text-[10px] text-muted mt-1 pl-1">
                                    {{ $article->scheduled_at->format('M d, H:i') }}
                                </div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-inset ring-green-600/20">
                                    <x-lucide-check-circle class="w-3 h-3 mr-1" />
                                    {{ __('admin.status.published') }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
