<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AdminArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index(Request $request)
    {
        $cacheKey = $this->buildAdminArticlesCacheKey($request);

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
                'articles' => $query->orderByDesc('scheduled_at')->orderByDesc('created_at')->paginate(10)->withQueryString(),
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
     * Build a stable, compact cache key for the admin articles list.
     */
    private function buildAdminArticlesCacheKey(Request $request): string
    {
        $parts = [
            'page' => (int) $request->get('page', 1),
            'category' => $request->get('category', ''),
            'search' => $request->get('search', ''),
            'v' => cache_version(),
        ];

        return 'admin_articles_' . sha1(json_encode($parts));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        $scheduledArticles = Article::whereNotNull('scheduled_at')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc')
            ->get();
            
        return view('admin.articles.create', [
            'categories' => Category::all(),
            'scheduledArticles' => $scheduledArticles
        ]);
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $this->validateArticle($request);
            
            $article = new Article($validated);
            $article->user_id = auth()->id();
            $article->slug = Str::slug($validated['title']);
            
            $this->handleScheduling($article, $request->scheduled_at);

            $article->save();

            // Handle gallery images (both new uploads and library media)
            if ($request->hasFile('gallery_images') || $request->has('library_media_ids')) {
                app(AdminImageController::class)->handleGalleryImages($request, $article);
            }

            $this->updateSEO($article);
            $this->clearArticleCaches();

            // Check for image warning and include it in the response
            $response = redirect()
                ->route('admin.articles.index')
                ->with('success', 'Article created successfully.');
            
            if (session()->has('image_warning')) {
                $response->with('warning', session('image_warning'));
                session()->forget('image_warning');
            }
            
            return $response;
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Get all validation errors
            $errors = $e->validator->errors();
            
            // Build a user-friendly message listing all missing mandatory fields
            $missingFields = [];
            $fieldLabels = [
                'title' => 'Title',
                'content' => 'Content',
                'category_id' => 'Category',
            ];
            
            foreach ($fieldLabels as $field => $label) {
                if ($errors->has($field)) {
                    $missingFields[] = $label;
                }
            }
            
            // Add custom validation errors (like tags)
            foreach ($errors->all() as $error) {
                if (str_contains($error, 'tags')) {
                    $missingFields[] = 'Tags (validation error)';
                    break;
                }
            }
            
            $errorMessage = 'Please fix the following issues before publishing:';
            if (!empty($missingFields)) {
                $errorMessage .= ' ' . implode(', ', $missingFields);
            } else {
                $errorMessage .= ' ' . implode(', ', $errors->all());
            }
            
            return back()
                ->withErrors($e->validator)
                ->with('error', $errorMessage)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Article creation error: ' . $e->getMessage());
            return back()
                ->with('error', 'Failed to create article: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        return view('admin.articles.preview', [
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
        // Refresh the article with its media relationship to ensure we have the latest data
        $article->load('media');
        
        $scheduledArticles = Article::whereNotNull('scheduled_at')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc')
            ->get();
            
        return view('admin.articles.edit', [
            'article' => $article,
            'categories' => Category::all(),
            'scheduledArticles' => $scheduledArticles
        ]);
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        try {
            $validated = $this->validateArticle($request, $article);
            
            // Begin transaction
            DB::transaction(function() use ($request, $article, $validated) {
                // Update article details
                $this->handleScheduling($article, $request->scheduled_at);
                $article->update($validated);

                // Handle gallery images (both new uploads and library media)
                if ($request->hasFile('gallery_images') || $request->has('library_media_ids')) {
                    app(AdminImageController::class)->handleGalleryImages($request, $article);
                }

                // Update SEO
                $this->updateSEO($article);
            });

            // Clear caches
            $this->clearArticleCaches();

            // Check for image warning and include it in the response
            $response = redirect()
                ->route('admin.articles.edit', $article)
                ->with('success', 'Article updated successfully.');
            
            if (session()->has('image_warning')) {
                $response->with('warning', session('image_warning'));
                session()->forget('image_warning');
            }
            
            return $response;

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Get all validation errors
            $errors = $e->validator->errors();
            
            // Build a user-friendly message listing all missing mandatory fields
            $missingFields = [];
            $fieldLabels = [
                'title' => 'Title',
                'content' => 'Content',
                'category_id' => 'Category',
            ];
            
            foreach ($fieldLabels as $field => $label) {
                if ($errors->has($field)) {
                    $missingFields[] = $label;
                }
            }
            
            // Add custom validation errors (like tags)
            foreach ($errors->all() as $error) {
                if (str_contains($error, 'tags')) {
                    $missingFields[] = 'Tags (validation error)';
                    break;
                }
            }
            
            $errorMessage = 'Please fix the following issues before saving:';
            if (!empty($missingFields)) {
                $errorMessage .= ' ' . implode(', ', $missingFields);
            } else {
                $errorMessage .= ' ' . implode(', ', $errors->all());
            }
            
            return back()
                ->withErrors($e->validator)
                ->with('error', $errorMessage)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Article update error', [
                'article_id' => $article->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->with('error', 'Failed to update article: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        // Delete all images associated with the article
        foreach ($article->media as $media) {
            // Check if this image is being used by other articles
            $isShared = \App\Models\Media::where('image_path', $media->image_path)
                ->where('id', '!=', $media->id)
                ->exists();
            
            // Only delete physical files if this is the last reference
            if (!$isShared) {
                // Delete main image file
                if ($media->image_path && Storage::disk('public')->exists($media->image_path)) {
                    Storage::disk('public')->delete($media->image_path);
                    
                    \Log::info('Deleted image file during article deletion (no other references)', [
                        'article_id' => $article->id,
                        'image_path' => $media->image_path,
                        'media_id' => $media->id
                    ]);
                }
                
                // Delete variants if they exist
                if (!empty($media->variants)) {
                    foreach ($media->variants as $variant) {
                        if ($variant && Storage::disk('public')->exists($variant)) {
                            Storage::disk('public')->delete($variant);
                        }
                    }
                }
            } else {
                \Log::info('Image file preserved during article deletion (still used by other articles)', [
                    'article_id' => $article->id,
                    'image_path' => $media->image_path,
                    'media_id' => $media->id,
                    'other_references' => \App\Models\Media::where('image_path', $media->image_path)
                        ->where('id', '!=', $media->id)
                        ->count()
                ]);
            }
            
            // Always delete the media record for this article
            $media->delete();
        }
        
        // Delete SEO data
        if ($article->seo) {
            $article->seo->delete();
        }
        
        // Delete the article
        $article->delete();

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
     * If no schedule date is provided, set scheduled_at to now() to publish immediately.
     */
    private function handleScheduling(Article $article, ?string $scheduledAt): void
    {
        if ($scheduledAt) {
            $scheduledAt = Carbon::parse($scheduledAt);
            // If scheduled date is in the future, use it; otherwise publish immediately
            $article->scheduled_at = $scheduledAt->isFuture() ? $scheduledAt : now();
        } else {
            // No schedule date provided - publish immediately
            $article->scheduled_at = now();
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
        } else {
            $titleRule .= '|unique:articles,title,' . $article->id;
        }

        $rules = [
            'title' => $titleRule,
            'excerpt' => 'nullable|max:255',
            'content' => 'required',
            'tags' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $tags = array_map('trim', explode(',', $value));
                        $tags = array_filter($tags); // Remove empty tags
                        
                        // Validate tag count (optimal: 5-10 tags)
                        if (count($tags) > 15) {
                            $fail('Too many tags. Recommended: 5-10 tags for optimal SEO. Maximum: 15 tags.');
                        }
                        
                        // Validate individual tag length (2-30 characters recommended)
                        foreach ($tags as $tag) {
                            if (strlen($tag) < 2) {
                                $fail("Tag '{$tag}' is too short. Tags should be at least 2 characters.");
                            }
                            if (strlen($tag) > 50) {
                                $fail("Tag '{$tag}' is too long. Tags should be maximum 50 characters.");
                            }
                        }
                        
                        // Check for duplicate tags (case-insensitive)
                        $lowerTags = array_map('strtolower', $tags);
                        if (count($lowerTags) !== count(array_unique($lowerTags))) {
                            $fail('Duplicate tags detected. Each tag should be unique.');
                        }
                    }
                }
            ],
            'category_id' => 'required|exists:categories,id',
            'scheduled_at' => 'nullable|date',
            
            // Options validation
            'youtube_link' => 'nullable|url|max:500',
            'instagram_link' => 'nullable|url|max:500',
            'local_store_link' => 'nullable|url|max:500',
        ];

        // Only validate images if they are being uploaded
        if ($request->hasFile('gallery_images')) {
            $rules['gallery_images'] = 'array|max:30';
            $rules['gallery_images.*'] = [
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:5120', // 5MB in kilobytes
                function ($attribute, $value, $fail) use ($article) {
                    // Check file size
                    if ($value->getSize() > 5 * 1024 * 1024) {
                        $fail("File {$value->getClientOriginalName()} is too large. Maximum file size is 5MB.");
                    }

                    // Check dimensions - allow up to 5120 in either dimension
                    $dimensions = getimagesize($value);
                    if ($dimensions[0] > 5120 || $dimensions[1] > 5120) {
                        $fail("File {$value->getClientOriginalName()} dimensions ({$dimensions[0]}x{$dimensions[1]}) exceed the maximum allowed size of 5120x5120 pixels.");
                    }
                    
                    // Check if this will be a cover image (first image if no cover exists)
                    $willBeCover = !$article || !$article->media()->where('is_cover', true)->exists();
                    if ($willBeCover) {
                        // Google Discovery recommends minimum 1200px width for cover images
                        // Log warning but don't fail - allow article creation with warning
                        if ($dimensions[0] < 1200) {
                            \Log::warning("Cover image width is below 1200px recommendation for Google Discovery", [
                                'width' => $dimensions[0],
                                'recommended' => 1200,
                                'dimensions' => "{$dimensions[0]}x{$dimensions[1]}"
                            ]);
                            // Store warning in session for user notification
                            session()->flash('image_warning', "Cover image width ({$dimensions[0]}px) is below the recommended 1200px for Google Discovery. The article will be created, but consider using a wider image for better SEO.");
                        }
                        
                        // Warn about aspect ratio (recommend 16:9 = 1.777...)
                        $aspectRatio = $dimensions[0] / $dimensions[1];
                        $optimalRatio = 16 / 9; // 1.777...
                        $ratioDiff = abs($aspectRatio - $optimalRatio);
                        if ($ratioDiff > 0.3) {
                            // Log warning but don't fail
                            \Log::warning("Cover image aspect ratio is not optimal for Google Discovery", [
                                'ratio' => round($aspectRatio, 2),
                                'optimal' => round($optimalRatio, 2),
                                'dimensions' => "{$dimensions[0]}x{$dimensions[1]}"
                            ]);
                        }
                    }
                }
            ];

            // Check total number of images (existing + new)
            if ($article) {
                $existingCount = $article->media()->count();
                $newCount = count($request->file('gallery_images'));
                if (($existingCount + $newCount) > 30) {
                    throw ValidationException::withMessages([
                        'gallery_images' => "Total number of images ({$existingCount} existing + {$newCount} new) exceeds the maximum limit of 30 images."
                    ]);
                }
            }
        }

        return $request->validate($rules);
    }

    /**
     * Handle gallery images upload.
     */

    /**
     * Update article SEO data.
     */
    private function updateSEO(Article $article): void
    {
        $coverImage = $article->media->firstWhere('is_cover', true);
        $article->seo()->updateOrCreate(
            [
                'model_id' => $article->id,
                'model_type' => Article::class,
            ],
            [
                'title' => $article->title,
                'description' => $article->excerpt ?? Str::limit(strip_tags($article->content), 160),
                'tags' => $article->tags,
                'image' => $coverImage ? $coverImage->image_path : null,
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


    /**
     * Display a listing of scheduled articles.
     */
    public function scheduled()
    {
        $scheduledArticles = Article::whereNotNull('scheduled_at')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc')
            ->with(['user', 'category'])
            ->get();

        return view('admin.articles.scheduled', [
            'articles' => $scheduledArticles
        ]);
    }
}
