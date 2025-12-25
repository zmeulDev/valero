<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Facades\SEO;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Media;



class Article extends Model
{
    use HasFactory, HasSEO;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'tags',
        'excerpt',
        'content',
        'is_featured',
        'scheduled_at',
        'views',
        'category_id',
        'likes_count',
        'youtube_link',
        'instagram_link',
        'local_store_link'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'scheduled_at' => 'datetime:Y-m-d H:i',
    ];

    protected $appends = ['tags_array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function coverImage()
    {
        return $this->hasOne(Media::class)->where('is_cover', true);
    }

    public function getCoverImageAttribute()
    {
        return $this->media()->where('is_cover', true)->first();
    }

    public function scopePublished($query)
    {
        return $query->where(function ($q) {
            $q->where('scheduled_at', '<=', now())
                ->orWhereNull('scheduled_at');
        });
    }

    /**
     * Get the reading time for the article.
     *
     * @return string
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);

        return $minutes . ' ' . __('frontend.common.minutes');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getTagsArrayAttribute(): array
    {
        return $this->tags ? array_map('trim', explode(',', $this->tags)) : [];
    }

    /**
     * Get SEO validation results for this article
     */
    public function getSEOValidation(): array
    {
        return [
            'title' => \App\Helpers\SEOValidator::validateTitle($this->title),
            'description' => \App\Helpers\SEOValidator::validateDescription($this->excerpt ?: Str::limit(strip_tags($this->content), 160)),
            'content_length' => \App\Helpers\SEOValidator::validateContentLength($this->content),
            'readability' => \App\Helpers\SEOValidator::calculateReadability($this->content),
        ];
    }

    /**
     * Get keyword density for primary keyword (category name)
     */
    public function getKeywordDensity(?string $keyword = null): array
    {
        $keyword = $keyword ?: $this->category->name ?? '';
        if (empty($keyword)) {
            return ['message' => 'No keyword provided'];
        }
        return \App\Helpers\SEOValidator::calculateKeywordDensity($this->content, $keyword);
    }

    public function getDynamicSEOData(): SEOData
    {
        // Get clean description, limiting to 160 chars for SEO best practices
        $description = Str::limit(
            strip_tags($this->excerpt ?: $this->content),
            160
        );

        // Calculate reading time once
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / 200);

        // Get cover image with absolute URL
        $coverMedia = $this->media->firstWhere('is_cover', true);
        $imageUrl = $coverMedia?->image_path
            ? url(Storage::url($coverMedia->image_path))
            : url(asset('storage/brand/logo.png'));

        // Get the correct article URL (absolute)
        $articleUrl = url(route('articles.index', ['slug' => $this->slug]));

        // Get keywords array
        $keywords = collect([
            $this->category->name,
            ...$this->tags_array,
            config('app.name')
        ])
            ->filter()
            ->unique()
            ->join(', ');

        // Helper to extract FAQs
        $faqs = $this->extractFaqs();

        $schemaCollection = SchemaCollection::make()
            ->addArticle(function ($schema) use ($imageUrl, $description, $readingTime, $wordCount, $articleUrl) {
                // Force BlogPosting type if possible (property might be public)
                if (property_exists($schema, 'type')) {
                    $schema->type = 'BlogPosting';
                }

                $schema->headline = $this->title;
                $schema->description = $description;

                // package 'image' property must be string
                $schema->image = $imageUrl;

                $schema->datePublished = $this->created_at;
                $schema->dateModified = $this->updated_at;
                $schema->author = [
                    '@type' => 'Person',
                    'name' => $this->user->name
                ];
                $schema->publisher = [
                    '@type' => 'Organization',
                    'name' => config('app_name'),
                    'url' => route('home'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => url(asset('storage/brand/logo.png'))
                    ]
                ];
                $schema->articleBody = $this->content;
                $schema->wordCount = $wordCount;
                $schema->timeRequired = "PT{$readingTime}M";
                $schema->keywords = $this->tags_array;
                $schema->mainEntityOfPage = [
                    '@type' => 'WebPage',
                    '@id' => $articleUrl
                ];

                return $schema;
            })
            ->addBreadcrumbs(function ($breadcrumbs) {
                return $breadcrumbs
                    ->prependBreadcrumbs([
                        'Home' => route('home'),
                        $this->category->name => route('category.index', $this->category),
                        $this->title => route('articles.index', ['slug' => $this->slug])
                    ]);
            });

        // Only add FAQPage if we actually have FAQs
        if (!empty($faqs)) {
            $schemaCollection->addFaqPage(function ($faqPage) use ($faqs) {
                foreach ($faqs as $faq) {
                    $faqPage->addQuestion(
                        name: $faq['question'],
                        acceptedAnswer: $faq['answer']
                    );
                }

                return $faqPage;
            });
        }

        return new SEOData(
            title: $this->title,
            description: $description,
            author: $this->user->name,
            image: $imageUrl, // Keep single URL for Open Graph/Twitter
            published_time: $this->created_at,
            modified_time: $this->updated_at,
            section: $this->category->name,
            tags: $this->tags_array,
            url: $articleUrl,
            type: 'BlogPosting',
            schema: $schemaCollection
        );
    }

    /**
     * Extract FAQs from article content
     * Supports H2/H3/Strong tags containing "Q:" or ending with "?"
     */
    protected function extractFaqs(): array
    {
        $faqs = [];

        // Flexible regex to catch questions in headings or bold text
        // Looks for: <h[234]> or <strong>, optional "Q:", captured question text, optional "?", closing tag,
        // followed by <p> captured answer </p>
        $patterns = [
            // Format 1: Heading/Strong Question + P Answer
            // <h2>Q: What is X?</h2> <p>It is Y...</p>
            '/<(h[2-4]|strong)[^>]*>(?:Q:\s*)?(.*?)<\/\1>\s*<p>(.*?)<\/p>/is',

            // Format 2: Mixed content with "Q:" and "A:" markers (handling breaks)
            // <h3><br><strong>Q: Question?</strong><br>A: Answer</h3>
            '/(?:Q:\s*|<strong>Q:\s*<\/strong>)(.*?)(?:<br\s*\/?>|<\/p>|<\/h[1-6]>)\s*(?:A:\s*|<strong>A:\s*<\/strong>)(.*?)(?:<br\s*\/?>|<\/p>|<\/h[1-6]>)/is',

            // Format 3: Simple "Q: ... A: ..." keys in text (fallback)
            '/Q:\s*(.*?)\s*A:\s*(.*?)(\n|<br)/i'
        ];

        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $this->content, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                // Ensure we strip tags to get clean text
                $question = trim(strip_tags($match[1]));
                $answer = trim(strip_tags($match[2]));

                // Simple validation: Question needs to be reasonable length
                if (strlen($question) > 3 && strlen($answer) > 2) {
                    $faqs[] = [
                        'question' => $question,
                        'answer' => $answer
                    ];
                }
            }
        }

        // De-duplicate based on questions
        $faqs = array_unique($faqs, SORT_REGULAR);

        // If no FAQs found, but title says FAQ, try to generate a default one
        if (empty($faqs) && str_contains(strtolower($this->title), 'faq')) {
            $excerpt = Str::limit(strip_tags($this->content), 150);
            if (!empty($excerpt)) {
                $faqs[] = [
                    'question' => "What is {$this->title} about?",
                    'answer' => $excerpt
                ];
            }
        }

        return $faqs;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    protected static function boot()
    {
        parent::boot();

        // Only handle cache versioning and sitemap
        static::created(function ($article) {
            increment_cache_version();
            /*
             * We use a closure or valid callable for queued jobs normally, 
             * but for simplicity in this plan we call the command directly.
             * In high traffic production, this should be dispatched to a queue.
             */
            \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
        });

        static::updated(function ($article) {
            increment_cache_version();
            \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
        });

        static::deleted(function ($article) {
            increment_cache_version();
            \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
        });
    }

}