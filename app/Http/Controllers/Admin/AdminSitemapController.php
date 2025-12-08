<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Article;
use App\Models\Category;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class AdminSitemapController extends Controller
{
    public function generate()
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
        
        if (request()->is('admin/generate-sitemap')) {
            return redirect()->back()->with('success', 'Sitemap generated successfully!');
        }
        return redirect()->back();
    }
}
