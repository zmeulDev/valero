<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;

class CleanupOrphanedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:cleanup-orphaned 
                            {--dry-run : Show orphaned files without deleting them}
                            {--force : Delete without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned image files that are not referenced by any media records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Scanning for orphaned image files...');
        $this->newLine();

        $disk = Storage::disk('public');
        $orphanedFiles = [];
        $totalSize = 0;

        // Get all image files from the images directory
        if (!$disk->exists('images')) {
            $this->warn('⚠️  Images directory does not exist.');
            return 0;
        }

        $allFiles = $disk->allFiles('images');
        $this->info("📁 Found " . count($allFiles) . " files in storage/app/public/images/");
        
        $progressBar = $this->output->createProgressBar(count($allFiles));
        $progressBar->start();

        foreach ($allFiles as $filePath) {
            // Check if this file is referenced in the media table
            $isReferenced = Media::where('image_path', $filePath)->exists();
            
            if (!$isReferenced) {
                $fileSize = $disk->size($filePath);
                $orphanedFiles[] = [
                    'path' => $filePath,
                    'size' => $fileSize,
                    'size_human' => $this->formatBytes($fileSize),
                    'modified' => date('Y-m-d H:i:s', $disk->lastModified($filePath))
                ];
                $totalSize += $fileSize;
            }
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        if (empty($orphanedFiles)) {
            $this->info('✅ No orphaned files found. All files are properly referenced!');
            return 0;
        }

        // Display orphaned files
        $this->warn('🗑️  Found ' . count($orphanedFiles) . ' orphaned file(s) totaling ' . $this->formatBytes($totalSize));
        $this->newLine();

        // Show details in a table
        $this->table(
            ['Path', 'Size', 'Last Modified'],
            array_map(function($file) {
                return [
                    $file['path'],
                    $file['size_human'],
                    $file['modified']
                ];
            }, array_slice($orphanedFiles, 0, 20)) // Show first 20
        );

        if (count($orphanedFiles) > 20) {
            $this->info('... and ' . (count($orphanedFiles) - 20) . ' more files');
            $this->newLine();
        }

        // Dry run mode
        if ($this->option('dry-run')) {
            $this->info('🔍 Dry run mode - no files were deleted');
            return 0;
        }

        // Confirm deletion
        if (!$this->option('force')) {
            if (!$this->confirm('⚠️  Do you want to delete these orphaned files?', false)) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        // Delete orphaned files
        $deleted = 0;
        $failed = 0;
        
        $this->info('🗑️  Deleting orphaned files...');
        $deleteProgress = $this->output->createProgressBar(count($orphanedFiles));
        $deleteProgress->start();

        foreach ($orphanedFiles as $file) {
            try {
                if ($disk->delete($file['path'])) {
                    $deleted++;
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                $this->error("Failed to delete {$file['path']}: {$e->getMessage()}");
                $failed++;
            }
            $deleteProgress->advance();
        }

        $deleteProgress->finish();
        $this->newLine(2);

        // Summary
        $this->info("✅ Cleanup complete!");
        $this->info("   Deleted: {$deleted} files ({$this->formatBytes($totalSize)})");
        if ($failed > 0) {
            $this->warn("   Failed: {$failed} files");
        }

        return 0;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
