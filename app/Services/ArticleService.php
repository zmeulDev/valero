<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class ArticleService
{
    public function createArticle(array $data)
    {
        // Handle article creation logic
    }

    public function updateArticle(Article $article, array $data)
    {
        // Handle article update logic
    }

    public function handleImages(Article $article, $images)
    {
        // Handle image upload logic
    }
} 