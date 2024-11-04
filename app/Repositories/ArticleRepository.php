<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    public function getPublishedArticles()
    {
        return Article::published()
            ->latest()
            ->paginate(10);
    }

    public function getPopularArticles($limit = 5)
    {
        return Article::published()
            ->orderBy('views', 'desc')
            ->take($limit)
            ->get();
    }
} 