<div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-2xl overflow-hidden mb-8 shadow-lg group">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    
    <div class="relative z-10 p-8 sm:p-10 flex flex-col sm:flex-row items-center gap-8">
        <!-- Image Section -->
        <div class="sm:w-2/5">
            <div class="relative aspect-[4/3] rounded-xl overflow-hidden shadow-2xl ring-1 ring-white/10">
                <img class="w-full h-full object-cover object-center transform transition-transform duration-500 group-hover:scale-105"
                    src="{{ $article->feature_image ? asset('storage/' . $article->feature_image) : asset('storage/brand/no-image.jpg') }}" 
                    alt="{{ $article->title }}" 
                    loading="lazy"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="sm:w-3/5 space-y-6">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 text-xs font-semibold bg-yellow-400 text-gray-900 rounded-full">
                    FEATURED
                </span>
                <a href="{{ route('category.index', $article->category->slug) }}" 
                   class="px-3 py-1 text-xs font-medium text-white/90 hover:text-white bg-white/10 rounded-full transition-colors duration-200">
                    {{ $article->category->name }}
                </a>
            </div>

            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white leading-tight">
                <a href="{{ route('articles.index', $article->slug) }}"
                   class="hover:text-yellow-400 transition-colors duration-200">
                    {{ Str::limit($article->title, 100) }}
                </a>
            </h2>

            <p class="text-gray-300 leading-relaxed line-clamp-3">
                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 160) }}
            </p>

            <div class="flex items-center justify-between pt-6 border-t border-white/10">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3">
                        <img class="w-10 h-10 rounded-full ring-2 ring-white/20"
                            src="{{ $article->user->profile_photo_url }}"
                            alt="{{ $article->user->name }}"
                            loading="lazy">
                        <div class="space-y-0.5">
                            <div class="text-white font-medium">{{ $article->user->name }}</div>
                            <div class="text-white/60 text-sm">
                                {{ $article->scheduled_at ? $article->scheduled_at->format('M d, Y') : $article->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <x-button-action href="{{ route('articles.index', $article->slug) }}"
                    class="group/btn inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-200">
                    Read Article
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover/btn:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </x-button-action>
            </div>
        </div>
    </div>
</div>
