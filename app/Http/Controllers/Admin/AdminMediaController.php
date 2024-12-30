<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminMediaController extends Controller
{
    public function index(Request $request)
    {
        // Base query with article relationship
        $query = Media::with('article');

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('filename', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%")
                  ->orWhereHas('article', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by type
        if ($type = $request->input('type')) {
            $query->where('mime_type', $type);
        }

        // Get filtered results for statistics
        $filteredCount = $query->count();

        // Get general statistics (unfiltered)
        try {
            $totalSize = Media::whereNotNull('size')
                ->where('size', '>', 0)
                ->sum('size');

            $statistics = [
                'total_count' => Media::count(),
                'total_size' => $totalSize ? number_format($totalSize / 1048576, 2) : 0,
                'cover_images' => Media::cover()->count(),
                'regular_images' => Media::notCover()->count(),
                'by_type' => Media::select('mime_type', DB::raw('count(*) as count'))
                    ->groupBy('mime_type')
                    ->get(),
                'filtered_count' => $filteredCount
            ];
        } catch (\Exception $e) {
            \Log::error('Error calculating media statistics: ' . $e->getMessage());
            
            // Fallback statistics with safe values
            $statistics = [
                'total_count' => 0,
                'total_size' => 0,
                'cover_images' => 0,
                'regular_images' => 0,
                'by_type' => collect(),
                'filtered_count' => 0
            ];
        }

        // Get paginated results
        $media = $query->latest()->paginate(24);

        return view('admin.media.index', compact('media', 'statistics'));
    }

    public function download(Media $media): StreamedResponse
    {
        // Use the public disk since files are in storage/app/public
        $disk = Storage::disk('public');

        // Remove any leading slash from the image path
        $path = ltrim($media->image_path, '/');

        // Check if the file exists in public storage
        if (!$disk->exists($path)) {
            \Log::error('File not found in public storage', [
                'media_id' => $media->id,
                'path' => $path,
                'full_path' => $disk->path($path)
            ]);
            abort(404, 'File not found');
        }

        try {
            // Get the original filename from the media record
            $filename = $media->filename;
            
            // Get the mime type from the media record or detect it
            $mimeType = $media->mime_type ?? $disk->mimeType($path);

            // Create the response with proper headers
            return $disk->download(
                $path,
                $filename,
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Error downloading media file: ' . $e->getMessage(), [
                'media_id' => $media->id,
                'path' => $path,
                'full_path' => $disk->path($path)
            ]);
            abort(500, 'Error downloading file');
        }
    }
}
