<?php

namespace App\Console\Commands;

use App\Models\Media;
use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ConvertImagesToWebp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:convert-webp {--force : Force conversion even if already WebP}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert all existing images to WebP format';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mediaItems = Media::all();
        $bar = $this->output->createProgressBar($mediaItems->count());
        $bar->start();

        // Initialize ImageManager
        // Prefer Imagick if available, else GD
        if (extension_loaded('imagick')) {
            $manager = new ImageManager(new \Intervention\Image\Drivers\Imagick\Driver());
        } else {
            $manager = new ImageManager(new Driver());
        }

        foreach ($mediaItems as $media) {
            try {
                // checks if file exists
                if (!$media->image_path || !Storage::disk('public')->exists($media->image_path)) {
                    $this->error(" File not found for Media ID: {$media->id}");
                    $bar->advance();
                    continue;
                }

                $originalPath = $media->image_path;
                $extension = strtolower(pathinfo($originalPath, PATHINFO_EXTENSION));

                // Skip if already WebP unless --force
                if ($extension === 'webp' && !$this->option('force')) {
                    $bar->advance();
                    continue;
                }

                // Skip non-image files (just in case)
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $bar->advance();
                    continue;
                }

                $fullPath = Storage::disk('public')->path($originalPath);
                $newFilename = pathinfo($originalPath, PATHINFO_FILENAME) . '.webp';
                $newStoredPath = 'images/' . $newFilename;
                $newFullPath = Storage::disk('public')->path($newStoredPath);

                // Read and Convert
                if (extension_loaded('imagick')) {
                    $imagick = new \Imagick($fullPath);
                    $imagick->setImageFormat('webp');
                    $imagick->setImageCompressionQuality(85);
                    $imagick->writeImage($newFullPath);
                    $imagick->clear();
                    $imagick->destroy();
                } else {
                    $image = $manager->read($fullPath);
                    $image->save($newFullPath, quality: 85);
                }

                $newSize = filesize($newFullPath);

                // Update Database
                $media->update([
                    'image_path' => $newStoredPath,
                    'filename' => $newFilename,
                    'mime_type' => 'image/webp',
                    'size' => $newSize
                ]);

                // Delete original file
                if ($originalPath !== $newStoredPath) {
                    Storage::disk('public')->delete($originalPath);
                }

                // Touch article to update SEO image path if this was cover
                if ($media->is_cover && $media->article) {
                    // Update SEO data manually since we can't easily trigger the controller method from here
                    // Or just touch the article and let valid observers run if any
                    $media->article->touch();
                }

            } catch (\Exception $e) {
                $this->error(" Failed to process Media ID {$media->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('All images converted to WebP successfully!');
    }
}
