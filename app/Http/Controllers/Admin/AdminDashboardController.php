<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Article stats
        $articleCount = Article::count();
        $publishedArticles = Article::query()
            ->published()
            ->count();
        $scheduledArticles = Article::query()
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '>', now())
            ->count();

        // User stats
        $userCount = User::count();
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(7))->count();
        
        // View stats
        $totalViews = Article::sum('views');
        $avgViewsPerArticle = $articleCount > 0 ? round($totalViews / $articleCount, 1) : 0;

        // Latest articles with relationships
        $articles = Article::with(['user', 'category'])
            ->orderByDesc('scheduled_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Recent activity
        $recentActivity = collect([
            // Articles created in last 7 days
            ...Article::with('user')
                ->where('created_at', '>=', now()->subDays(7))
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($article) {
                    return [
                        'type' => 'article_created',
                        'user' => $article->user->name,
                        'title' => $article->title,
                        'date' => $article->created_at,
                        'url' => route('admin.articles.edit', $article)
                    ];
                }),
            // Users who logged in recently
            ...User::where('last_login_at', '>=', now()->subDays(2))
                ->latest('last_login_at')
                ->take(5)
                ->get()
                ->map(function ($user) {
                    return [
                        'type' => 'user_login',
                        'user' => $user->name,
                        'date' => $user->last_login_at,
                        'url' => route('admin.teams.edit', $user)
                    ];
                })
        ])->sortByDesc('date')
         ->take(5)
         ->values();

        return view('admin.dashboard', compact(
            'articleCount',
            'publishedArticles',
            'scheduledArticles',
            'userCount',
            'activeUsers',
            'totalViews',
            'avgViewsPerArticle',
            'articles',
            'recentActivity'
        ));
    }

    public function clearCache()
    {
        increment_cache_version();
        Cache::forget('article_stats');
        Cache::forget('all_categories');
        Cache::forget('frontend_categories_' . cache_version());
        
        return back()->with('success', 'Cache cleared successfully!');
    }
}