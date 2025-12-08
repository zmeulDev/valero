<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $cacheKey = 'home_page_data_' . cache_version() . '_page_' . request('page', 1);
        
        $data = Cache::remember($cacheKey, now()->addMinutes(30), function () {
            return [
                'articles' => Article::with(['category', 'user'])
                    ->published()
                    ->orderByDesc('scheduled_at')
                    ->orderByDesc('created_at')
                    ->paginate(12),
                'categories' => $this->getCachedCategories(),
                'featuredArticle' => Article::with(['category', 'user'])
                    ->published()
                    ->orderByDesc('scheduled_at')
                    ->orderByDesc('created_at')
                    ->first(),
                'popularArticles' => Article::with(['category', 'user'])
                    ->published()
                    ->orderBy('views', 'desc')
                    ->take(5)
                    ->get()
            ];
        });

        return view('frontend.home', [
            ...$data,
            'role' => auth()->check() && auth()->user()->isAdmin()
        ]);
    }

    private function getCachedCategories()
    {
        return Cache::remember('frontend_categories_' . cache_version(), now()->addHours(1), function () {
            return Category::withCount('articles')->get();
        });
    }
}