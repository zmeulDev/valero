<div x-data="seoManager()" x-init="initSeo()" class="space-y-6">
    <!-- SEO Score Badge -->
    <div class="flex items-center justify-between bg-surface shadow-sm rounded-lg border border-border p-4">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <x-lucide-bar-chart class="w-5 h-5 text-indigo-500" />
            </div>
            <div>
                <h3 class="text-sm font-medium text-text">{{ __('admin.articles.seo_score') }}</h3>
                <p class="text-xs text-muted" x-text="scoreText"></p>
            </div>
        </div>
        <div class="flex items-center">
            <span :class="scoreBadgeClass" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" x-text="scoreLabel"></span>
        </div>
    </div>

    <!-- Google SERP Preview -->
    <div class="bg-surface shadow-sm rounded-lg border border-border p-4">
        <h3 class="text-sm font-medium text-text mb-3 flex items-center space-x-2">
            <x-lucide-search class="w-4 h-4 text-muted" />
            <span>{{ __('admin.articles.google_preview') }}</span>
        </h3>
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 max-w-2xl">
            <div class="text-xs text-gray-600 dark:text-gray-400 mb-1 truncate" x-text="previewUrl"></div>
            <div class="text-lg text-[#1a0dab] dark:text-[#8ab4f8] font-medium truncate leading-tight cursor-pointer hover:underline" x-text="previewTitle"></div>
            <div class="text-sm text-[#4d5156] dark:text-gray-300 leading-normal mt-1 line-clamp-2" x-text="previewDescription"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- SEO Title -->
        <div>
            <label for="meta_title" class="block text-sm font-medium text-text mb-1">
                {{ __('admin.articles.seo_title') }}
            </label>
            @php
                $defaultTitle = $article?->meta_title ?? ($article?->title ?? old('title', ''));
            @endphp
            <input type="text" id="meta_title" name="meta_title"
                x-model="seoTitle"
                @input="markTitleEdited(); updatePreview()"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-background text-text border-border"
                placeholder="{{ __('admin.articles.seo_title_placeholder', ['title' => $article?->title ?? old('title', '')]) }}"
                value="{{ old('meta_title', $defaultTitle) }}">
            <div class="mt-2 flex items-center justify-between text-sm">
                <p class="text-muted">{{ __('admin.articles.seo_title_help') }}</p>
                <p class="text-sm" :class="titleCountClass">
                    <span x-text="titleCount"></span> {{ __('admin.articles.chars') }}
                </p>
            </div>
        </div>

        <!-- Meta Description -->
        <div>
            <label for="meta_description" class="block text-sm font-medium text-text mb-1">
                {{ __('admin.articles.seo_description') }}
            </label>
            @php
                $defaultDesc = $article?->meta_description ?? ($article ? \App\Helpers\SeoHelper::smartTruncate($article->excerpt ?: strip_tags($article->content), 160) : '');
            @endphp
            <textarea id="meta_description" name="meta_description"
                x-model="metaDescription"
                @input="markDescEdited(); updatePreview()"
                rows="3"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-background text-text border-border"
                placeholder="{{ __('admin.articles.seo_description_placeholder') }}"
            >{{ old('meta_description', $defaultDesc) }}</textarea>
            <div class="mt-2 flex items-center justify-between text-sm">
                <p class="text-muted">{{ __('admin.articles.seo_description_help') }}</p>
                <p class="text-sm" :class="descCountClass">
                    <span x-text="descCount"></span> {{ __('admin.articles.chars') }}
                </p>
            </div>
        </div>

        <!-- Robots -->
        <div>
            <label for="meta_robots" class="block text-sm font-medium text-text mb-1">
                {{ __('admin.articles.seo_robots') }}
            </label>
            <select id="meta_robots" name="meta_robots"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-background text-text border-border">
                @foreach(['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow'] as $option)
                    <option value="{{ $option }}" @selected(old('meta_robots', $article?->meta_robots ?? 'index, follow') === $option)>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
            <p class="mt-1 text-xs text-muted">{{ __('admin.articles.seo_robots_help') }}</p>
        </div>

        <!-- Canonical URL -->
        <div>
            <label for="canonical_url" class="block text-sm font-medium text-text mb-1">
                {{ __('admin.articles.seo_canonical_url') }}
            </label>
            @php
                $defaultCanonical = $article?->canonical_url ?? ($article ? route('articles.index', $article->slug) : '');
            @endphp
            <input type="url" id="canonical_url" name="canonical_url"
                class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-background text-text border-border"
                placeholder="https://example.com/original-article"
                value="{{ old('canonical_url', $defaultCanonical) }}">
            <p class="mt-1 text-xs text-muted">{{ __('admin.articles.seo_canonical_help') }}</p>
        </div>
    </div>
</div>

<script>
function seoManager() {
    return {
        seoTitle: '{{ old('meta_title', $article?->meta_title ?? ($article?->title ?? old('title', ''))) }}',
        metaDescription: '{{ old('meta_description', $article?->meta_description ?? ($article ? Str::limit(html_entity_decode(strip_tags($article->excerpt ?: $article->content)), 160) : '')) }}',
        articleTitle: '{{ $article?->title ?? old('title', '') }}',
        articleExcerpt: '{{ $article ? Str::limit(html_entity_decode(strip_tags($article->excerpt ?: $article->content)), 160) : old('excerpt', '') }}',
        siteName: '{{ config('app_name') }}',
        slug: '{{ $article?->slug ?? '' }}',
        baseUrl: '{{ url('/') }}',
        isCreateMode: {{ $article ? 'false' : 'true' }},
        titleCount: 0,
        descCount: 0,
        titleCountClass: 'text-muted',
        descCountClass: 'text-muted',
        previewUrl: '',
        previewTitle: '',
        previewDescription: '',
        scoreLabel: 'Needs Improvement',
        scoreText: 'Fill in your SEO title and description.',
        scoreBadgeClass: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
        titleEditedByUser: false,
        descEditedByUser: false,

        initSeo() {
            this.updatePreview();

            if (this.isCreateMode) {
                this.setupAutoSync();
            }
        },

        setupAutoSync() {
            const titleInput = document.getElementById('title');
            const excerptInput = document.getElementById('excerpt');

            if (titleInput) {
                titleInput.addEventListener('input', () => {
                    this.articleTitle = titleInput.value;
                    if (!this.titleEditedByUser) {
                        this.seoTitle = titleInput.value;
                        this.updatePreview();
                    }
                });
            }

            if (excerptInput) {
                excerptInput.addEventListener('input', () => {
                    this.articleExcerpt = excerptInput.value;
                    if (!this.descEditedByUser) {
                        this.metaDescription = this.limitChars(excerptInput.value, 160);
                        this.updatePreview();
                    }
                });
            }
        },

        limitChars(text, max) {
            if (!text) return '';
            return text.length > max ? text.substring(0, max) : text;
        },

        markTitleEdited() {
            this.titleEditedByUser = true;
        },

        markDescEdited() {
            this.descEditedByUser = true;
        },

        updatePreview() {
            this.titleCount = this.seoTitle.length;
            this.descCount = this.metaDescription.length;

            // Title color coding
            if (this.titleCount >= 30 && this.titleCount <= 60) {
                this.titleCountClass = 'text-green-600 dark:text-green-400 font-medium';
            } else if (this.titleCount === 0 || (this.titleCount > 60 && this.titleCount <= 70)) {
                this.titleCountClass = 'text-yellow-600 dark:text-yellow-400';
            } else {
                this.titleCountClass = 'text-red-600 dark:text-red-400 font-medium';
            }

            // Description color coding
            if (this.descCount >= 140 && this.descCount <= 160) {
                this.descCountClass = 'text-green-600 dark:text-green-400 font-medium';
            } else if (this.descCount === 0 || (this.descCount >= 120 && this.descCount <= 180)) {
                this.descCountClass = 'text-yellow-600 dark:text-yellow-400';
            } else {
                this.descCountClass = 'text-red-600 dark:text-red-400 font-medium';
            }

            // Preview data
            const displayTitle = this.seoTitle || this.articleTitle;
            const displayDesc = this.metaDescription || this.articleExcerpt;
            const path = this.slug ? '/articles/' + this.slug : '/articles/example';

            this.previewUrl = this.baseUrl + path;
            this.previewTitle = displayTitle ? (displayTitle + ' - ' + this.siteName) : this.siteName;
            this.previewDescription = displayDesc || 'No description provided.';

            // Score calculation
            const titleGood = this.titleCount >= 30 && this.titleCount <= 60;
            const descGood = this.descCount >= 140 && this.descCount <= 160;

            if (titleGood && descGood) {
                this.scoreLabel = 'Good';
                this.scoreText = 'Your SEO looks great!';
                this.scoreBadgeClass = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300';
            } else if ((titleGood || this.titleCount === 0) && (descGood || this.descCount === 0)) {
                this.scoreLabel = 'Needs Improvement';
                this.scoreText = 'Optimizing your title and description will improve click-through rates.';
                this.scoreBadgeClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300';
            } else {
                this.scoreLabel = 'Needs Improvement';
                this.scoreText = 'Your title or description length is outside the recommended range.';
                this.scoreBadgeClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300';
            }
        }
    }
}
</script>
