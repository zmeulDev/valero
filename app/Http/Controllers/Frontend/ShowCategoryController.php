<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use App\Models\Setting;
use Illuminate\Support\Str;

class ShowCategoryController extends Controller
{
    public function index($slug)
    {
        // Fetch the category by slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Fetch published articles that belong to this category
        $articles = Article::published()
            ->where('category_id', $category->id)
            ->orderByDesc('scheduled_at')
            ->orderByDesc('created_at')
            ->paginate(4);

        // Fetch popular published articles
        $popularArticles = Article::published()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $categories = Category::all();

        // Fetch featured published article
        $featuredArticle = Article::published()
            ->orderBy('views', 'desc')
            ->first();

        // Return the view with the articles and category data
        return view('layouts.category', compact(
            'articles', 
            'category', 
            'popularArticles', 
            'categories', 
            'featuredArticle'
        ));
    }
}