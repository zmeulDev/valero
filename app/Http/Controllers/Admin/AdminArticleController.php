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
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

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

            // Handle gallery images with improved error handling
            if ($request->hasFile('gallery_images')) {
                $this->handleGalleryImages($request, $article);
            }

            $this->updateSEO($article);
            $this->clearArticleCaches();

            return redirect()
                ->route('admin.articles.index')
                ->with('success', 'Article created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Article creation error: ' . $e->getMessage());
            return back()
                ->with('error', 'Failed to create article: ' . $e->getMessage());
        }
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

                // Handle gallery images if any are uploaded
                if ($request->hasFile('gallery_images')) {
                    $this->handleGalleryImages($request, $article);
                }

                // Update SEO
                $this->updateSEO($article);
            });

            // Clear caches
            $this->clearArticleCaches();

            return redirect()
                ->route('admin.articles.edit', $article)
                ->with('success', 'Article updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
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
        // Ensure all images are deleted before the article
        foreach ($article->media as $media) {
            $this->deleteArticleImages($article, $media);
        }
        
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
        } else {
            $titleRule .= '|unique:articles,title,' . $article->id;
        }

        $rules = [
            'title' => $titleRule,
            'excerpt' => 'nullable|max:255',
            'content' => 'required',
            'tags' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'scheduled_at' => 'nullable|date',
            
            // Buying options validation
            'amazon_link' => 'nullable|url|max:255',
            'ebay_link' => 'nullable|url|max:255',
            'local_store_link' => 'nullable|url|max:255',
            'lowest_price' => 'nullable|numeric|min:0|max:999999.99',
            'average_price' => 'nullable|numeric|min:0|max:999999.99',
        ];

        // Only validate images if they are being uploaded
        if ($request->hasFile('gallery_images')) {
            $rules['gallery_images'] = 'array|max:20';
            $rules['gallery_images.*'] = [
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:5120', // 5MB in kilobytes
                function ($attribute, $value, $fail) {
                    // Check file size
                    if ($value->getSize() > 5 * 1024 * 1024) {
                        $fail("File {$value->getClientOriginalName()} is too large. Maximum file size is 5MB.");
                    }

                    // Check dimensions
                    $dimensions = getimagesize($value);
                    if ($dimensions[0] > 3840 || $dimensions[1] > 2160) {
                        $fail("File {$value->getClientOriginalName()} dimensions ({$dimensions[0]}x{$dimensions[1]}) exceed the maximum allowed size of 3840x2160 pixels.");
                    }
                }
            ];

            // Check total number of images (existing + new)
            if ($article) {
                $existingCount = $article->media()->count();
                $newCount = count($request->file('gallery_images'));
                if (($existingCount + $newCount) > 20) {
                    throw ValidationException::withMessages([
                        'gallery_images' => "Total number of images ({$existingCount} existing + {$newCount} new) exceeds the maximum limit of 20 images."
                    ]);
                }
            }
        }

        return $request->validate($rules);
    }

    /**
     * Handle gallery images upload.
     */
    private function handleGalleryImages(Request $request, Article $article): void
    {
        try {
            // Enhanced logging
            Log::info('Gallery Images Upload Started', [
                'article_id' => $article->id,
                'has_files' => $request->hasFile('gallery_images'),
                'file_count' => $request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0,
                'existing_count' => $article->media->count()
            ]);

            // Validate file input explicitly
            if (!$request->hasFile('gallery_images')) {
                Log::warning('No gallery images found in request');
                return;
            }

            $files = $request->file('gallery_images');
            
            // Ensure we don't exceed the maximum number of images
            $remainingSlots = 20 - $article->media->count();
            if (count($files) > $remainingSlots) {
                Log::warning('Too many files submitted', [
                    'submitted' => count($files),
                    'remaining_slots' => $remainingSlots
                ]);
                throw new \Exception("You can only upload {$remainingSlots} more images. (Maximum total: 20)");
            }

            // Initialize ImageManager once for all images
            try {
                $manager = new ImageManager(new Driver());
            } catch (\Exception $e) {
                Log::error('Failed to initialize ImageManager', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw new \Exception('Failed to initialize image processing: ' . $e->getMessage());
            }

            // Check if a cover image already exists
            $hasCoverImage = $article->media()->where('is_cover', true)->exists();

            // Process all files in a transaction
            DB::transaction(function() use ($files, $article, $manager, &$hasCoverImage) {
                foreach ($files as $index => $imageFile) {
                    try {
                        // Validate image dimensions before processing
                        $dimensions = getimagesize($imageFile);
                        if ($dimensions[0] > 3840 || $dimensions[1] > 2160) {
                            throw new \Exception("Image dimensions ({$dimensions[0]}x{$dimensions[1]}) exceed the maximum allowed size of 3840x2160 pixels.");
                        }

                        // Store original image
                        $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
                        $path = $imageFile->storeAs('images', $filename, 'public');

                        // Create media record without processing first
                        $mediaData = [
                            'article_id' => $article->id,
                            'image_path' => $path,
                            'is_cover' => !$hasCoverImage,
                            'filename' => $filename,
                            'mime_type' => $imageFile->getMimeType(),
                            'size' => $imageFile->getSize(),
                            'dimensions' => [
                                'width' => $dimensions[0],
                                'height' => $dimensions[1]
                            ],
                            'alt_text' => $article->title
                        ];

                        // Create the media record
                        $media = Media::create($mediaData);

                        // Try to process the image
                        try {
                            $img = $manager->read($imageFile);
                            
                            if ($dimensions[0] > 1920) {
                                $img->scale(width: 1920);
                                $img->save(storage_path('app/public/' . $path));
                            }

                        } catch (\Exception $e) {
                            Log::warning('Failed to process image, but file was uploaded', [
                                'media_id' => $media->id,
                                'error' => $e->getMessage()
                            ]);
                        }

                        // Update hasCoverImage flag after successful creation
                        if ($media->is_cover) {
                            $hasCoverImage = true;
                        }

                        Log::info('Media record created', [
                            'media_id' => $media->id,
                            'is_cover' => $media->is_cover,
                            'image_path' => $path
                        ]);

                    } catch (\Exception $e) {
                        Log::error('Image upload error', [
                            'message' => $e->getMessage(),
                            'file' => $e->getFile(),
                            'line' => $e->getLine(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        throw $e;
                    }
                }
            });

            // Final logging
            Log::info('Gallery Images Upload Completed', [
                'article_id' => $article->id,
                'total_media_count' => $article->media()->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Gallery upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

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

    private function handleImageDeletion(Media $media): void
    {
        // Delete image files
        if ($media->image_path && Storage::disk('public')->exists($media->image_path)) {
            Storage::disk('public')->delete($media->image_path);
        }
        
        // Delete variants if they exist
        if (!empty($media->variants)) {
            foreach ($media->variants as $variant) {
                if ($variant && Storage::disk('public')->exists($variant)) {
                    Storage::disk('public')->delete($variant);
                }
            }
        }
    }

    /**
     * Delete a specific article image.
     */
    public function deleteArticleImages(Article $article, Media $media)
    {
        // Check if request wants JSON response
        $wantsJson = request()->ajax() || request()->wantsJson();

        if (Auth::user()->id !== $article->user_id && !Auth::user()->isAdmin()) {
            return $wantsJson 
                ? response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403)
                : redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            DB::transaction(function() use ($article, $media) {
                // Delete the image files
                $this->handleImageDeletion($media);
                
                // Delete the media record
                $media->delete();

                // Update SEO data if needed
                if ($media->is_cover) {
                    $this->updateSEO($article);
                }
            });

            // Return appropriate response based on request type
            return $wantsJson 
                ? response()->json([
                    'success' => true,
                    'message' => 'Image deleted successfully',
                    'remainingImages' => $article->media->count()
                ])
                : redirect()->back()->with('success', 'Image deleted successfully');

        } catch (\Exception $e) {
            Log::error('Image deletion error', [
                'message' => $e->getMessage(),
                'article_id' => $article->id,
                'media_id' => $media->id,
                'trace' => $e->getTraceAsString()
            ]);

            return $wantsJson
                ? response()->json(['success' => false, 'message' => 'Failed to delete image'], 400)
                : redirect()->back()->with('error', 'Failed to delete image');
        }
    }

    public function setCover(Article $article, Media $media)
    {
        // Validate that the media exists and is an image
        if (!$media->exists() || !Str::startsWith($media->mime_type, 'image/')) {
            return redirect()->back()->with('error', 'Invalid media item');
        }

        // Ensure the image belongs to the article
        if ($media->article_id !== $article->id) {
            return redirect()->back()->with('error', 'Invalid image for this article');
        }

        // Ensure the user has permission
        if (Auth::user()->id !== $article->user_id && !Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        try {
            // Begin transaction to ensure atomic operation
            DB::transaction(function () use ($article, $media) {
                // Remove current cover
                $article->media()->where('is_cover', true)->update(['is_cover' => false]);
                
                // Set new cover
                $media->refresh(); // Refresh the model to ensure we have latest data
                $media->is_cover = true;
                $media->save();

                // Update SEO data with new cover image
                $this->updateSEO($article);
            });

            // Clear any relevant caches
            $this->clearArticleCaches();

            // Log the operation
            Log::info('Cover image updated', [
                'article_id' => $article->id,
                'media_id' => $media->id,
                'user_id' => Auth::id()
            ]);

            return redirect()->back()->with('success', 'Cover image updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to set cover image', [
                'article_id' => $article->id,
                'media_id' => $media->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Failed to set cover image: ' . $e->getMessage());
        }
    }

    /**
     * Store images for an article.
     */
    public function storeImages(Request $request, Article $article)
    {
        try {
            // Enhanced logging
            Log::info('Gallery Images Upload Started', [
                'article_id' => $article->id,
                'has_files' => $request->hasFile('gallery_images'),
                'file_count' => $request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0,
                'existing_count' => $article->media->count()
            ]);

            // Validate file input explicitly
            if (!$request->hasFile('gallery_images')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No images found in request'
                ], 400);
            }

            $files = $request->file('gallery_images');
            
            // Ensure we don't exceed the maximum number of images
            $remainingSlots = 20 - $article->media->count();
            if (count($files) > $remainingSlots) {
                return response()->json([
                    'success' => false,
                    'message' => "Maximum total of 20 images allowed. You currently have {$article->media->count()} images and are trying to upload " . 
                                count($files) . " more. You can only upload {$remainingSlots} more images."
                ], 400);
            }

            // Initialize ImageManager
            $manager = new ImageManager(new Driver());

            // Check if a cover image already exists
            $hasCoverImage = $article->media()->where('is_cover', true)->exists();

            $uploadedImages = [];

            // Process all files in a transaction
            DB::transaction(function() use ($files, $article, $manager, &$hasCoverImage, &$uploadedImages) {
                foreach ($files as $imageFile) {
                    try {
                        // Validate image dimensions before processing
                        $dimensions = getimagesize($imageFile);
                        if ($dimensions[0] > 3840 || $dimensions[1] > 2160) {
                            throw new \Exception("Image dimensions ({$dimensions[0]}x{$dimensions[1]}) exceed the maximum allowed size of 3840x2160 pixels.");
                        }

                        // Generate unique filename
                        $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
                        $path = $imageFile->storeAs('images', $filename, 'public');

                        // Process image
                        $img = $manager->read($imageFile);
                        
                        if ($dimensions[0] > 1920) {
                            $img->scale(width: 1920);
                            $img->save(storage_path('app/public/' . $path));
                        }

                        // Create media record
                        $media = Media::create([
                            'article_id' => $article->id,
                            'image_path' => $path,
                            'is_cover' => !$hasCoverImage,
                            'filename' => $filename,
                            'mime_type' => $imageFile->getMimeType(),
                            'size' => $imageFile->getSize(),
                            'dimensions' => [
                                'width' => $dimensions[0],
                                'height' => $dimensions[1]
                            ],
                            'alt_text' => $article->title
                        ]);

                        if ($media->is_cover) {
                            $hasCoverImage = true;
                        }

                        $uploadedImages[] = [
                            'id' => $media->id,
                            'url' => asset('storage/' . $path),
                            'filename' => $filename
                        ];

                    } catch (\Exception $e) {
                        // If image processing fails, delete the stored file
                        if (isset($path) && Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                        throw $e;
                    }
                }
            });

            return response()->json([
                'success' => true,
                'message' => count($uploadedImages) . ' image(s) uploaded successfully',
                'images' => $uploadedImages
            ]);

        } catch (\Exception $e) {
            Log::error('Gallery upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload images: ' . $e->getMessage()
            ], 500);
        }
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
