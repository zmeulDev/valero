<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Article;
use App\Models\Category;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting sitemap generation...');

        $sitemap = Sitemap::create();

        // Add homepage (highest priority)
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setLastModificationDate(now()));

        // Add static pages
        $sitemap->add(Url::create('/cookie-policy')
            ->setPriority(0.5)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setLastModificationDate(now()));

        // Add category pages (high priority)
        $this->info('Adding categories...');
        Category::withCount('articles')
            ->has('articles')
            ->get()
            ->each(function (Category $category) use ($sitemap) {
                $sitemap->add(
                    Url::create("/category/{$category->slug}")
                        ->setLastModificationDate($category->updated_at)
                        ->setPriority(0.9)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                );
            });

        // Add only published articles
        $this->info('Adding articles...');
        Article::published()
            ->with('category')
            ->get()
            ->each(function (Article $article) use ($sitemap) {
                $sitemap->add(
                    Url::create("/articles/{$article->slug}")
                        ->setLastModificationDate($article->updated_at)
                        ->setPriority(0.8)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                );
            });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }
}
