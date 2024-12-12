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



class Article extends Model
{
    use HasFactory, HasSEO;

    protected $fillable = [
        'user_id', 'title', 'slug', 'tags', 'excerpt', 'content', 'featured_image', 'scheduled_at', 'views', 'category_id', 'likes_count'
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

    public function images()
    {
        return $this->hasMany(Image::class);
    }


    public function scopePublished($query)
    {
        return $query->where(function($q) {
            $q->where('scheduled_at', '<=', now())
            ->orWhereNull('scheduled_at');
        });
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getTagsArrayAttribute(): array
    {
        return $this->tags ? array_map('trim', explode(',', $this->tags)) : [];
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

        // Get image URL with fallback
        $imageUrl = $this->featured_image
            ? Storage::url($this->featured_image)
            : asset('storage/brand/default-article.jpg');

        // Get keywords array
        $keywords = array_merge(
            [$this->category->name],
            $this->tags_array
        );

        return new SEOData(
            title: $this->title,
            description: $description,
            author: $this->user->name,
            image: $imageUrl,
            published_time: $this->created_at,
            modified_time: $this->updated_at,
            section: $this->category->name,
            tags: $this->tags_array,
            schema: SchemaCollection::make()
                ->addArticle(function($schema) use ($imageUrl, $description, $readingTime, $wordCount, $keywords) {
                    $schema->headline = $this->title;
                    $schema->description = $description;
                    $schema->image = $imageUrl;
                    $schema->datePublished = $this->created_at;
                    $schema->dateModified = $this->updated_at;
                    $schema->inLanguage = app()->getLocale();
                    $schema->articleBody = $this->content;
                    $schema->wordCount = $wordCount;
                    $schema->timeRequired = "PT{$readingTime}M";
                    $schema->author = $this->user->name;
                    $schema->publisher = config('app.name');
                    $schema->mainEntityOfPage = route('articles.index', ['slug' => $this->slug]);
                    $schema->keywords = implode(', ', $keywords);

                    return $schema;
                })
                ->addBreadcrumbs(function($breadcrumbs, SEOData $SEOData) {
                    return $breadcrumbs
                        ->prependBreadcrumbs([
                            'Home' => route('home'),
                            $this->category->name => route('category.index', $this->category),
                            $this->title => route('articles.index', ['slug' => $this->slug])
                        ]);
                })
                ->addFaqPage(function($faqPage, SEOData $SEOData) {
                    // Extract questions and answers from content
                    $faqs = $this->extractFaqs();
                    
                    // Add each FAQ to the schema
                    foreach ($faqs as $faq) {
                        $faqPage->addQuestion(
                            name: $faq['question'],
                            acceptedAnswer: $faq['answer']
                        );
                    }

                    return $faqPage;
                })
        );
    }

    /**
     * Extract FAQs from article content
     * This is a basic implementation - adjust based on your content structure
     */
    protected function extractFaqs(): array
    {
        $faqs = [];
        
        // Example: Look for content between <h3>Q:</h3> and the next heading
        preg_match_all('/<h3>Q:\s*(.*?)<\/h3>\s*<p>(.*?)<\/p>/is', $this->content, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $faqs[] = [
                'question' => strip_tags($match[1]),
                'answer' => strip_tags($match[2])
            ];
        }
        
        // If no FAQs found, you might want to return some default FAQs
        if (empty($faqs) && str_contains(strtolower($this->title), 'faq')) {
            $faqs[] = [
                'question' => "What is {$this->title} about?",
                'answer' => Str::limit(strip_tags($this->content), 100)
            ];
        }
        
        return $faqs;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    protected static function booted()
    {
        static::created(function ($article) {
            increment_cache_version();
        });

        static::updated(function ($article) {
            increment_cache_version();
        });

        static::deleted(function ($article) {
            increment_cache_version();
        });
    }

}