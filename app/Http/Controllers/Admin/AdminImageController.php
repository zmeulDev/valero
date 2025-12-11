<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class AdminImageController extends Controller
{
    /**
     * Handle gallery images upload for an article.
     */
    public function handleGalleryImages(Request $request, Article $article): void
    {
        try {
            // Enhanced logging
            Log::info('Gallery Images Upload Started', [
                'article_id' => $article->id,
                'has_files' => $request->hasFile('gallery_images'),
                'file_count' => $request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0,
                'has_library_media' => $request->has('library_media_ids'),
                'library_count' => $request->has('library_media_ids') ? count($request->input('library_media_ids', [])) : 0,
                'existing_count' => $article->media->count()
            ]);

            // Handle library media attachment first
            if ($request->has('library_media_ids')) {
                $this->attachLibraryMedia($request, $article);
            }

            // If there are no file uploads, we're done (library media was handled above)
            if (!$request->hasFile('gallery_images')) {
                Log::info('No new file uploads, only library media processed');
                return;
            }

            $files = $request->file('gallery_images');
            
            // Ensure we don't exceed the maximum number of images
            $remainingSlots = 30 - $article->media->count();
            if (count($files) > $remainingSlots) {
                Log::warning('Too many files submitted', [
                    'submitted' => count($files),
                    'remaining_slots' => $remainingSlots
                ]);
                throw new \Exception("You can only upload {$remainingSlots} more images. (Maximum total: 30)");
            }

            // Initialize ImageManager - prefer Imagick for better quality
            $manager = $this->initializeImageManager();

            // Check if a cover image already exists
            $hasCoverImage = $article->media()->where('is_cover', true)->exists();

            // Process all files in a transaction
            DB::transaction(function() use ($files, $article, $manager, &$hasCoverImage) {
                foreach ($files as $index => $imageFile) {
                    try {
                        // Validate image dimensions before processing - allow up to 5120 in either dimension
                        $dimensions = getimagesize($imageFile);
                        if ($dimensions[0] > 5120 || $dimensions[1] > 5120) {
                            throw new \Exception("Image dimensions ({$dimensions[0]}x{$dimensions[1]}) exceed the maximum allowed size of 5120x5120 pixels.");
                        }

                        // Generate unique filename - normalize .jpeg to .jpg for consistency
                        $extension = strtolower($imageFile->getClientOriginalExtension());
                        if ($extension === 'jpeg') {
                            $extension = 'jpg';
                        }
                        $filename = uniqid() . '.' . $extension;

                        // Generate descriptive alt text
                        $altText = $article->title;
                        if ($index === 0 && !$hasCoverImage) {
                            $altText = "Cover image for {$article->title}";
                        } elseif ($index > 0) {
                            $altText = "Image " . ($index + 1) . " for {$article->title}";
                        }

                        // Store original dimensions
                        $originalWidth = $dimensions[0];
                        $originalHeight = $dimensions[1];
                        $newWidth = $originalWidth;
                        $newHeight = $originalHeight;
                        
                        // Determine if this will be a cover image
                        $willBeCover = ($index === 0 && !$hasCoverImage);
                        
                        // Check if image needs processing (scaling)
                        $needsProcessing = false;
                        if ($willBeCover && $originalWidth > 1920) {
                            $needsProcessing = true;
                            $newWidth = 1920;
                            $newHeight = (int)($originalHeight * (1920 / $originalWidth));
                        } elseif (!$willBeCover && $originalWidth > 1920) {
                            $needsProcessing = true;
                            $newWidth = 1920;
                            $newHeight = (int)($originalHeight * (1920 / $originalWidth));
                        } elseif ($willBeCover && $originalWidth < 1200) {
                            Log::warning('Cover image is below 1200px width', [
                                'article_id' => $article->id,
                                'width' => $originalWidth
                            ]);
                        }

                        // Process or store image using Laravel's file storage methods
                        $result = $this->processImage($imageFile, $filename, $needsProcessing, $manager, $newWidth);
                        $path = $result['path'];
                        $finalSize = $result['size'];

                        // Create media record with final dimensions
                        $mediaData = [
                            'article_id' => $article->id,
                            'image_path' => $path,
                            'is_cover' => !$hasCoverImage,
                            'filename' => $filename,
                            'mime_type' => $imageFile->getMimeType(),
                            'size' => $finalSize ?? $imageFile->getSize(),
                            'dimensions' => [
                                'width' => $newWidth ?? $dimensions[0],
                                'height' => $newHeight ?? $dimensions[1]
                            ],
                            'alt_text' => $altText
                        ];

                        // Create the media record
                        $media = Media::create($mediaData);

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
     * Store images for an article (AJAX endpoint).
     */
    public function store(Request $request, Article $article)
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

            // Initialize ImageManager - prefer Imagick for better quality
            $manager = $this->initializeImageManager();

            // Check if a cover image already exists
            $hasCoverImage = $article->media()->where('is_cover', true)->exists();

            $uploadedImages = [];

            // Process all files in a transaction
            DB::transaction(function() use ($files, $article, $manager, &$hasCoverImage, &$uploadedImages) {
                foreach ($files as $imageIndex => $imageFile) {
                    try {
                        // Validate image dimensions before processing - allow up to 5120 in either dimension
                        $dimensions = getimagesize($imageFile);
                        if ($dimensions[0] > 5120 || $dimensions[1] > 5120) {
                            throw new \Exception("Image dimensions ({$dimensions[0]}x{$dimensions[1]}) exceed the maximum allowed size of 5120x5120 pixels.");
                        }
                        
                        // Check if this will be a cover image (first image if no cover exists)
                        $willBeCover = ($imageIndex === 0 && !$hasCoverImage);
                        if ($willBeCover) {
                            // Google Discovery recommends minimum 1200px width for cover images
                            if ($dimensions[0] < 1200) {
                                Log::warning("Cover image width is below 1200px recommendation for Google Discovery", [
                                    'article_id' => $article->id,
                                    'width' => $dimensions[0],
                                    'recommended' => 1200,
                                    'dimensions' => "{$dimensions[0]}x{$dimensions[1]}"
                                ]);
                                session()->flash('image_warning', "Cover image width ({$dimensions[0]}px) is below the recommended 1200px for Google Discovery. The article will be created, but consider using a wider image for better SEO.");
                            }
                            
                            // Warn about aspect ratio (recommend 16:9 = 1.777...)
                            $aspectRatio = $dimensions[0] / $dimensions[1];
                            $optimalRatio = 16 / 9;
                            $ratioDiff = abs($aspectRatio - $optimalRatio);
                            if ($ratioDiff > 0.3) {
                                Log::warning("Cover image aspect ratio is not optimal for Google Discovery", [
                                    'article_id' => $article->id,
                                    'ratio' => round($aspectRatio, 2),
                                    'optimal' => round($optimalRatio, 2),
                                    'dimensions' => "{$dimensions[0]}x{$dimensions[1]}"
                                ]);
                            }
                        }

                        // Generate unique filename - normalize .jpeg to .jpg for consistency
                        $extension = strtolower($imageFile->getClientOriginalExtension());
                        if ($extension === 'jpeg') {
                            $extension = 'jpg';
                        }
                        $filename = uniqid() . '.' . $extension;

                        // Store original dimensions - NO RESIZING to preserve colors
                        $originalWidth = $dimensions[0];
                        $originalHeight = $dimensions[1];
                        
                        // Log warning if cover image is below recommended width
                        if ($willBeCover && $originalWidth < 1200) {
                            Log::warning('Cover image is below 1200px width', [
                                'article_id' => $article->id,
                                'width' => $originalWidth
                            ]);
                        }

                        // Upload image at original size - NO processing to preserve perfect colors
                        $result = $this->processImage($imageFile, $filename, false, $manager, $originalWidth);
                        $path = $result['path'];
                        $finalSize = $result['size'];

                        // Generate descriptive alt text
                        $imageIndex = count($uploadedImages);
                        $altText = $article->title;
                        if ($imageIndex === 0 && !$hasCoverImage) {
                            $altText = "Cover image for {$article->title}";
                        } elseif ($imageIndex > 0) {
                            $altText = "Image " . ($imageIndex + 1) . " for {$article->title}";
                        }

                        // Create media record
                        $media = Media::create([
                            'article_id' => $article->id,
                            'image_path' => $path,
                            'is_cover' => !$hasCoverImage,
                            'filename' => $filename,
                            'mime_type' => $imageFile->getMimeType(),
                            'size' => $finalSize ?? $imageFile->getSize(),
                            'dimensions' => [
                                'width' => $dimensions[0],
                                'height' => $dimensions[1]
                            ],
                            'alt_text' => $altText
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
     * Delete a specific article image.
     */
    public function destroy(Article $article, Media $media)
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
                $this->deleteImageFiles($media);
                
                // Delete the media record
                $media->delete();

                // Update SEO data if needed (article will handle this)
                if ($media->is_cover) {
                    // The article will need to update SEO with new cover
                    $article->touch(); // Touch to trigger any observers
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

    /**
     * Set image as cover.
     */
    public function setCover(Article $article, Media $media)
    {
        // Validate that the media is an image
        if (!Str::startsWith($media->mime_type ?? '', 'image/')) {
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
            // Capture old cover ID before transaction
            $oldCoverId = $article->media()->where('is_cover', true)->value('id');
            
            // Begin transaction to ensure atomic operation
            DB::transaction(function () use ($article, $media) {
                // Remove current cover from all images
                $article->media()->where('is_cover', true)->update(['is_cover' => false]);
                
                // Set new cover
                $media->update(['is_cover' => true]);
                
                // Refresh article's media relationship
                $article->load('media');
                
                // Update SEO data with new cover image
                $this->updateArticleSEO($article);
            });
            
            // Clear article caches
            $this->clearArticleCaches();

            // Log the operation
            Log::info('Cover image updated', [
                'article_id' => $article->id,
                'media_id' => $media->id,
                'old_cover' => $oldCoverId,
                'new_cover' => $media->id,
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
     * Attach library media to an article (helper method).
     */
    private function attachLibraryMedia(Request $request, Article $article): void
    {
        $mediaIds = $request->input('library_media_ids', []);
        if (empty($mediaIds)) {
            return;
        }

        $hasCover = $article->media()->where('is_cover', true)->exists();
        
        foreach ($mediaIds as $index => $mediaId) {
            $originalMedia = Media::find($mediaId);
            
            if (!$originalMedia) {
                Log::warning('Library media not found', ['media_id' => $mediaId]);
                continue;
            }
            
            // Create a duplicate media record for this article
            // (We duplicate so the original article still has its media)
            Media::create([
                'article_id' => $article->id,
                'image_path' => $originalMedia->image_path,
                'filename' => $originalMedia->filename,
                'mime_type' => $originalMedia->mime_type,
                'size' => $originalMedia->size,
                'dimensions' => $originalMedia->dimensions,
                'alt_text' => $originalMedia->alt_text,
                'is_cover' => ($index === 0 && !$hasCover) // First image becomes cover if no cover exists
            ]);
            
            if ($index === 0 && !$hasCover) {
                $hasCover = true;
            }
        }
        
        Log::info('Library media attached', [
            'article_id' => $article->id,
            'attached_count' => count($mediaIds)
        ]);
    }

    /**
     * Attach existing media from library to an article (AJAX endpoint).
     */
    public function attachFromLibrary(Request $request, Article $article)
    {
        $request->validate([
            'media_ids' => 'required|array|min:1',
            'media_ids.*' => 'required|exists:media,id'
        ]);

        try {
            DB::transaction(function () use ($request, $article) {
                $mediaIds = $request->input('media_ids');
                $hasCover = $article->media()->where('is_cover', true)->exists();
                
                foreach ($mediaIds as $index => $mediaId) {
                    $originalMedia = Media::findOrFail($mediaId);
                    
                    // Create a duplicate media record for this article
                    // (We duplicate so the original article still has its media)
                    Media::create([
                        'article_id' => $article->id,
                        'image_path' => $originalMedia->image_path,
                        'filename' => $originalMedia->filename,
                        'mime_type' => $originalMedia->mime_type,
                        'size' => $originalMedia->size,
                        'dimensions' => $originalMedia->dimensions,
                        'alt_text' => $originalMedia->alt_text,
                        'is_cover' => ($index === 0 && !$hasCover) // First image becomes cover if no cover exists
                    ]);
                    
                    if ($index === 0 && !$hasCover) {
                        $hasCover = true;
                    }
                }
                
                // Refresh article's media relationship
                $article->load('media');
                
                // Update SEO data if a new cover was set
                if ($article->media()->where('is_cover', true)->exists()) {
                    $this->updateArticleSEO($article);
                }
            });
            
            // Clear caches
            $this->clearArticleCaches();

            return response()->json([
                'success' => true,
                'message' => 'Images attached successfully',
                'count' => count($request->input('media_ids')),
                'total_images' => $article->media->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to attach media from library', [
                'article_id' => $article->id,
                'media_ids' => $request->input('media_ids'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to attach images: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update article SEO data.
     */
    private function updateArticleSEO(Article $article): void
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

    /**
     * Clear article caches.
     */
    private function clearArticleCaches(): void
    {
        increment_cache_version();
        \Cache::forget('article_stats');
        \Cache::forget('all_categories');
    }

    /**
     * Initialize ImageManager with preferred driver.
     */
    private function initializeImageManager(): ImageManager
    {
        // Try to use Imagick driver if available (better quality and color preservation)
        // Fall back to GD driver if Imagick is not available
        if (extension_loaded('imagick')) {
            return new ImageManager(new \Intervention\Image\Drivers\Imagick\Driver());
        }
        
        return new ImageManager(new Driver());
    }

    /**
     * Process or copy image based on whether scaling is needed.
     * Follows Laravel best practices for file storage.
     * Preserves color profiles when using Imagick.
     */
    private function processImage($imageFile, string $filename, bool $needsProcessing, ImageManager $manager, int $newWidth): array
    {
        $storedPath = 'images/' . $filename;
        $fullPath = storage_path('app/public/' . $storedPath);
        
        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // If no processing needed, upload the original file without ANY changes
        if (!$needsProcessing) {
            // Direct copy - preserves everything exactly as uploaded
            copy($imageFile->getRealPath(), $fullPath);
            $size = filesize($fullPath);
            
            return [
                'path' => $storedPath,
                'size' => $size
            ];
        }
        
        // Only process if scaling is needed - use Imagick to preserve ICC color profiles
        $tempPath = sys_get_temp_dir() . '/' . $filename;
        
        try {
            // Check if we're using Imagick driver
            $usingImagick = extension_loaded('imagick');
            
            if ($usingImagick) {
                // Use Imagick directly to preserve color profiles during resizing
                $imagick = new \Imagick($imageFile->getRealPath());
                
                // Preserve original colorspace
                $originalColorspace = $imagick->getImageColorspace();
                
                // Extract ICC profile before processing
                $profiles = $imagick->getImageProfiles("icc", true);
                
                // Set quality BEFORE resizing to avoid quality loss
                $extension = strtolower($imageFile->getClientOriginalExtension());
                if (in_array($extension, ['jpg', 'jpeg'])) {
                    $imagick->setImageCompressionQuality(95);
                } elseif ($extension === 'webp') {
                    $imagick->setImageCompressionQuality(95);
                }
                
                // Resize image with high-quality LANCZOS filter
                $imagick->resizeImage($newWidth, 0, \Imagick::FILTER_LANCZOS, 1);
                
                // Restore the original colorspace
                $imagick->setImageColorspace($originalColorspace);
                
                // Re-apply ICC profile after processing
                if (!empty($profiles) && isset($profiles['icc'])) {
                    $imagick->profileImage("icc", $profiles['icc']);
                }
                
                // Write to temporary file
                $imagick->writeImage($tempPath);
                $imagick->clear();
                $imagick->destroy();
            } else {
                // Fall back to Intervention Image with GD driver
                // Note: GD doesn't preserve color profiles as well
                $img = $manager->read($imageFile);
                $img->scale(width: $newWidth);
                
                // Save to temporary location with high quality
                $extension = strtolower($imageFile->getClientOriginalExtension());
                if (in_array($extension, ['jpg', 'jpeg'])) {
                    $img->save($tempPath, quality: 95);
                } elseif ($extension === 'png') {
                    $img->save($tempPath);
                } elseif ($extension === 'webp') {
                    $img->save($tempPath, quality: 95);
                } else {
                    $img->save($tempPath);
                }
            }

            // Move the processed file to final location
            rename($tempPath, $fullPath);
            $size = filesize($fullPath);
            
            return [
                'path' => $storedPath,
                'size' => $size
            ];
        } catch (\Exception $e) {
            // Clean up temporary file if it exists
            if (isset($tempPath) && file_exists($tempPath)) {
                @unlink($tempPath);
            }
            
            Log::error('Image processing failed', [
                'error' => $e->getMessage(),
                'filename' => $filename,
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }

    /**
     * Delete image files from storage (only if not used by other articles).
     */
    private function deleteImageFiles(Media $media): void
    {
        // Check if this image is being used by other articles
        $isShared = Media::where('image_path', $media->image_path)
            ->where('id', '!=', $media->id)
            ->exists();
        
        // Only delete physical files if this is the last reference
        if (!$isShared) {
            // Delete main image file
            if ($media->image_path && Storage::disk('public')->exists($media->image_path)) {
                Storage::disk('public')->delete($media->image_path);
                
                Log::info('Deleted image file (no other references)', [
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
            Log::info('Image file not deleted (still used by other articles)', [
                'image_path' => $media->image_path,
                'media_id' => $media->id,
                'other_references' => Media::where('image_path', $media->image_path)
                    ->where('id', '!=', $media->id)
                    ->count()
            ]);
        }
    }
}

