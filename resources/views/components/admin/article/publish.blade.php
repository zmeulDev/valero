@props(['article'])

<!-- Publish Button Card -->
<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 sticky top-6">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('admin.articles.last_updated') }}: {{ $article->updated_at->diffForHumans() }}
                            </span>
                            <span class="px-3 py-1 text-xs font-medium {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full">
                                {{ ucfirst($article->status) }}
                            </span>
                        </div>
                        <div class="flex gap-3">
                            <!-- View Live Button -->
                            <a href="{{ $article->scheduled_at && $article->scheduled_at->isFuture() ? route('articles.preview', $article->slug) : route('articles.index', $article->slug) }}" 
                               target="_blank" 
                               class="flex-1 inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:text-indigo-300 dark:bg-indigo-900/30 dark:hover:bg-indigo-900/50 transition duration-150 ease-in-out">
                                <x-lucide-external-link class="w-4 h-4 mr-1.5" />
                                {{ __('admin.articles.preview_article') }}
                            </a>
                            
                            <!-- Submit Button -->
                            <button type="submit"
                                    :disabled="submitting"
                                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center justify-center disabled:opacity-75 disabled:cursor-not-allowed">
                                <template x-if="!submitting">
                                    <div class="flex items-center">
                                        <x-lucide-save class="w-5 h-5 mr-2" />
                                        {{ __('admin.articles.update_article') }}
                                    </div>
                                </template>
                                <template x-if="submitting">
                                    <div class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        {{ __('admin.articles.updating') }}
                                    </div>
                                </template>
                            </button>
                        </div>
                    </div>
                </div>