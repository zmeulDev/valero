<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Models\Playlist;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerator
{
    public static function generate(): void
    {
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

        // Add categories list page
        $sitemap->add(Url::create('/categories')
            ->setPriority(0.7)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setLastModificationDate(now()));

        // Add playlists list page
        $sitemap->add(Url::create('/playlists')
            ->setPriority(0.7)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setLastModificationDate(now()));

        // Add category pages (high priority)
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

        // Add playlist pages
        Playlist::withCount('articles')
            ->has('articles')
            ->get()
            ->each(function (Playlist $playlist) use ($sitemap) {
                $sitemap->add(
                    Url::create("/playlists/{$playlist->slug}")
                        ->setLastModificationDate($playlist->updated_at)
                        ->setPriority(0.8)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                );
            });

        // Add only published articles
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
    }
}
