<div class="relative w-full mb-8 mt-8 group">
    <!-- Featured Image -->
    <div class="relative overflow-hidden rounded-2xl aspect-[16/9]">
    @if($article->featured_image)
        <x-article.has-image :article="$article" />
        @else
        <x-article.no-image />
        @endif
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
    </div>

    <!-- Category Badge and Views -->
        <div class="absolute bottom-6 left-6 flex items-center gap-3">
        <a href="{{ route('category.index', $article->category->slug) }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-900 rounded-full text-sm font-medium transition-all duration-300 hover:bg-white hover:scale-105">
            <x-lucide-tag class="w-4 h-4" />
            {{ $article->category->name }}
        </a>

        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-900 rounded-full text-sm font-medium">
            <x-lucide-eye class="w-4 h-4" />
            {{ number_format($article->views) }} views
        </div>
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-900 rounded-full text-sm font-medium">
            <x-lucide-clock class="w-4 h-4" />
            <span class="text-sm font-medium">{{ $article->reading_time ?? 'As long as you need.' }}</span>
        </div>
    </div>
</div>
<header class="relative max-w-4xl mx-auto px-4 pt-12 pb-16">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Left Sidebar - Meta -->
        <div class="md:w-48 md:pr-8 md:border-r border-gray-200 dark:border-gray-700 space-y-8">
            <!-- Author Info -->
            <div class="flex items-center gap-4 group">
                <div class="relative transform transition-transform duration-300 group-hover:scale-105">
                    <img src="{{ $article->user->profile_photo_url }}" 
                         alt="{{ $article->user->name }}" 
                         class="w-12 h-12 rounded-full object-cover ring-2 ring-white dark:ring-gray-700 shadow-lg">
                    <div class="absolute -bottom-0.5 -right-0.5 bg-green-500 w-3 h-3 rounded-full border-2 border-white dark:border-gray-800"></div>
                </div>
                <div class="space-y-0.5">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $article->user->name }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $article->author->title ?? 'Author' }}
                    </p>
                </div>
            </div>

            <!-- Meta Information -->
            <div class="space-y-6">
                <!-- Date -->
                <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                    <x-lucide-calendar class="w-5 h-5" />
                    <time datetime="{{ $article->created_at }}" class="text-sm font-medium">
                        {{ $article->created_at->format('M d, Y') }}
                    </time>
                </div>

                <!-- Like Button -->
                <button 
                    data-article-id="{{ $article->id }}"
                    class="like-button group w-full inline-flex items-center justify-center gap-3 px-6 py-3 bg-white dark:bg-gray-800 hover:bg-rose-50 dark:hover:bg-rose-900/10 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-rose-200 dark:hover:border-rose-700 transition-all duration-300 shadow-sm hover:shadow-md"
                >
                    <x-lucide-heart class="w-5 h-5 text-gray-400 group-hover:text-rose-500 dark:text-gray-500 dark:group-hover:text-rose-400 transition-colors duration-300" />
                    <span id="likeCount-{{ $article->id }}" 
                          class="text-sm font-semibold text-gray-700 group-hover:text-rose-600 dark:text-gray-300 dark:group-hover:text-rose-400 transition-colors duration-300">
                        {{ number_format($article->likes_count ?? 0) }}
                    </span>
                </button>
            </div>

        
        </div>

        <!-- Main Content -->
        <div class="flex-1 md:pl-8 space-y-8">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-tight">
                {{ $article->title }}
            </h1>

            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/40 via-purple-50/40 to-rose-50/40 dark:from-indigo-950/40 dark:via-purple-950/40 dark:to-rose-950/40 rounded-2xl transform rotate-0.5"></div>
                <blockquote class="relative p-8 text-lg md:text-xl text-gray-600 dark:text-gray-300 leading-relaxed rounded-2xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-100 dark:border-gray-700 shadow-sm">
                    {{ $article->excerpt }}
                </blockquote>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-button');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const articleId = this.dataset.articleId;
            const likeCount = document.getElementById(`likeCount-${articleId}`);
            const likeIcon = document.getElementById(`likeIcon-${articleId}`);
            const isLiked = likeIcon.classList.contains('text-red-500');
            
            fetch(`/articles/${articleId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ liked: !isLiked })
            })
            .then(response => response.json())
            .then(data => {
                likeCount.style.transform = 'scale(1.2)';
                likeCount.textContent = new Intl.NumberFormat().format(data.likes_count);
                
                if (isLiked) {
                    likeIcon.classList.remove('text-red-500');
                    likeIcon.classList.add('text-gray-400');
                } else {
                    likeIcon.classList.add('text-red-500');
                    likeIcon.classList.remove('text-gray-400');
                }
                
                setTimeout(() => {
                    likeCount.style.transform = 'scale(1)';
                }, 200);
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
