@props(['article'])

<div class="space-y-6">
    <!-- External Links Section -->
    <div class="bg-surface shadow-sm rounded-lg border border-border p-6">
        <h3 class="text-lg font-medium text-text mb-4">
            {{ __('admin.articles.external_links') }}
        </h3>

        <div class="space-y-4">
            <p class="text-sm text-muted mb-4">
                {{ __('admin.articles.external_links_description') }}
            </p>

            <!-- YouTube Link -->
            <div>
                <label for="youtube_link" class="block text-sm font-medium text-text">
                    YouTube <span class="text-xs font-normal text-muted">({{ __('admin.common.optional') }})</span>
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-muted" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </div>
                    <input type="url" name="youtube_link" id="youtube_link"
                        class="block w-full rounded-md border-border pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-background text-text placeholder-muted"
                        placeholder="https://youtube.com/watch?v=..."
                        value="{{ old('youtube_link', $article?->youtube_link) }}">
                </div>
                <p class="mt-1 text-xs text-muted">{{ __('admin.articles.youtube_help') }}</p>
            </div>

            <!-- Instagram Link -->
            <div>
                <label for="instagram_link" class="block text-sm font-medium text-text">
                    Instagram <span class="text-xs font-normal text-muted">({{ __('admin.common.optional') }})</span>
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-muted" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </div>
                    <input type="url" name="instagram_link" id="instagram_link"
                        class="block w-full rounded-md border-border pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-background text-text placeholder-muted"
                        placeholder="https://instagram.com/p/..."
                        value="{{ old('instagram_link', $article?->instagram_link) }}">
                </div>
                <p class="mt-1 text-xs text-muted">{{ __('admin.articles.instagram_help') }}</p>
            </div>

            <!-- Local Store Link -->
            <div>
                <label for="local_store_link" class="block text-sm font-medium text-text">
                    {{ __('admin.articles.local_store_link') }} <span
                        class="text-xs font-normal text-muted">({{ __('admin.common.optional') }})</span>
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-lucide-shopping-bag class="h-5 w-5 text-muted" />
                    </div>
                    <input type="url" name="local_store_link" id="local_store_link"
                        class="block w-full rounded-md border-border pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-background text-text placeholder-muted"
                        placeholder="https://example.com/product/..."
                        value="{{ old('local_store_link', $article?->local_store_link) }}">
                </div>
                <p class="mt-1 text-xs text-muted">{{ __('admin.articles.local_store_help') }}</p>
            </div>
        </div>
    </div>
</div>