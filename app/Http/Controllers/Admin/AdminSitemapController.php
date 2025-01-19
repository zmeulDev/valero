<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Article;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class AdminSitemapController extends Controller
{
    public function generate()
    {
        $sitemap = Sitemap::create();

        // Add static pages
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        // Add only published articles
        Article::query()
            ->where(function($query) {
                $query->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', Carbon::now());
            })
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
