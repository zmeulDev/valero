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

class AdminArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index()
    {
        $selectedCategory = request()->get('category');
        $categories = Category::all();
        
        $articles = Article::with(['user', 'category'])
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->where('category_id', $selectedCategory);
            })
            ->latest()
            ->paginate(10);

        $stats = $this->getArticleStats();

        return view('admin.articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'totalArticles' => $stats['total'],
            'publishedArticles' => $stats['published'],
            'scheduledArticles' => $stats['scheduled']
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
            $this->handleGalleryImages($request, $article);
        }

        $this->updateSEO($article);

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

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }

    /**
     * Get article statistics.
     */
    private function getArticleStats(): array
    {
        return [
            'total' => Article::count(),
            'published' => Article::query()
                ->whereNull('scheduled_at')
                ->orWhere('scheduled_at', '<=', now())
                ->count(),
            'scheduled' => Article::query()
                ->whereNotNull('scheduled_at')
                ->where('scheduled_at', '>', now())
                ->count()
        ];
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
        $this->deleteOldFeaturedImage($article);

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
        $article->seo->updateOrCreate(
            [
                'model_id' => $article->id,
                'model_type' => Article::class,
            ],
            [
                'title' => $article->title,
                'description' => $article->excerpt,
                'image' => $article->featured_image,
                'author' => auth()->user()->name,
                'robots' => 'index, follow',
                'canonical_url' => route('articles.index', $article->slug),
            ]
        );
    }
}
