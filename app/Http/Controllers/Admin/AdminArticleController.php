<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Facades\Cache;

class AdminArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index(Request $request)
    {
        $cacheKey = 'admin_articles_' . 
                    $request->get('page', 1) . '_' . 
                    $request->get('category', '') . '_' . 
                    $request->get('search', '') . '_' .
                    cache_version();

        $data = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($request) {
            $query = Article::with(['user', 'category']);

            // Handle category filter
            if ($request->has('category')) {
                $query->where('category_id', $request->category);
            }

            // Handle search
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhereHas('category', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            }

            return [
                'articles' => $query->latest()->paginate(10)->withQueryString(),
                'stats' => $this->getArticleStats(),
                'categories' => Cache::remember('all_categories_' . cache_version(), now()->addHours(1), function () {
                    return Category::orderBy('name')->get();
                })
            ];
        });

        return view('admin.articles.index', [
            'articles' => $data['articles'],
            'categories' => $data['categories'],
            'selectedCategory' => $request->category,
            'totalArticles' => $data['stats']['total'],
            'publishedArticles' => $data['stats']['published'],
            'scheduledArticles' => $data['stats']['scheduled']
        ]);
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        return view('admin.articles.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateArticle($request);
        
        $article = new Article($validated);
        $article->user_id = auth()->id();
        $article->slug = Str::slug($validated['title']);
        
        $this->handleScheduling($article, $request->scheduled_at);
        
        if ($request->hasFile('featured_image')) {
            $article->featured_image = $this->handleFeaturedImage($request);
        }

        $article->save();

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('images', 'public');
                $article->images()->create(['image_path' => $path]);
            }
        }

        $this->updateSEO($article);

        // Clear relevant caches
        $this->clearArticleCaches();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', [
            'article' => $article,
            'popularArticles' => Article::orderBy('views', 'desc')->take(5)->get(),
            'categories' => Category::all(),
            'readingTime' => ceil(str_word_count(strip_tags($article->content)) / 200),
            'status' => $article->scheduled_at ? 'Scheduled' : 'Published'
        ]);
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', [
            'article' => $article,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $this->validateArticle($request, $article);
        
        $this->handleScheduling($article, $request->scheduled_at);
        
        $article->update($validated);

        if ($request->hasFile('featured_image')) {
            $this->deleteOldFeaturedImage($article);
            $article->featured_image = $this->handleFeaturedImage($request);
            $article->save();
        }

        if ($request->hasFile('gallery_images')) {
            $this->handleGalleryImages($request, $article);
        }

        $this->updateSEO($article);

        // Clear relevant caches
        $this->clearArticleCaches();

        return redirect()
            ->route('admin.articles.edit', $article)
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        $this->deleteArticleImages($article);
        $article->delete();
        $article->seo->delete();

        // Clear relevant caches
        $this->clearArticleCaches();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }

    /**
     * Get article statistics.
     */
    private function getArticleStats(): array
    {
        return Cache::remember('article_stats', now()->addMinutes(5), function () {
            $now = now();
            return [
                'total' => Article::count(),
                'published' => Article::where(function($query) use ($now) {
                    $query->whereNull('scheduled_at')
                          ->orWhere('scheduled_at', '<=', $now);
                })->count(),
                'scheduled' => Article::where('scheduled_at', '>', $now)->count()
            ];
        });
    }

    /**
     * Handle article scheduling.
     */
    private function handleScheduling(Article $article, ?string $scheduledAt): void
    {
        if ($scheduledAt) {
            $scheduledAt = Carbon::parse($scheduledAt);
            $article->scheduled_at = $scheduledAt->isFuture() ? $scheduledAt : null;
        } else {
            $article->scheduled_at = null;
        }
    }

    /**
     * Validate article request data.
     */
    private function validateArticle(Request $request, ?Article $article = null): array
    {
        $titleRule = 'required|max:255';
        if (!$article) {
            $titleRule .= '|unique:articles';
        }

        return $request->validate([
            'title' => $titleRule,
            'excerpt' => 'nullable|max:255',
            'content' => 'required',
            'tags' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'scheduled_at' => 'nullable|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }

    /**
     * Handle featured image upload.
     */
    private function handleFeaturedImage(Request $request): string
    {
        return $request->file('featured_image')->store('images', 'public');
    }

    /**
     * Delete old featured image.
     */
    private function deleteOldFeaturedImage(Article $article): void
    {
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }
    }

    /**
     * Handle gallery images upload.
     */
    private function handleGalleryImages(Request $request, Article $article): void
    {
        foreach ($request->file('gallery_images') as $image) {
            $path = $image->store('images', 'public');
            $article->images()->create(['image_path' => $path]);
        }
    }

    /**
     * Delete all article images.
     */
    private function deleteArticleImages(Article $article): void
    {
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        foreach ($article->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }

    /**
     * Update article SEO data.
     */
    private function updateSEO(Article $article): void
    {
        $article->seo()->updateOrCreate(
            [
                'model_id' => $article->id,
                'model_type' => Article::class,
            ],
            [
                'title' => $article->title,
                'description' => $article->excerpt ?? Str::limit(strip_tags($article->content), 160),
                'tags' => $article->tags,
                'image' => $article->featured_image,
                'author' => $article->user->name,
                'robots' => 'index, follow',
                'canonical_url' => route('articles.index', $article->slug),
                'created_at' => $article->scheduled_at ?? $article->created_at,
                'updated_at' => $article->updated_at,
            ]
        );
    }

    private function clearArticleCaches(): void
    {
        increment_cache_version();
        Cache::forget('article_stats');
        Cache::forget('all_categories');
    }
}
