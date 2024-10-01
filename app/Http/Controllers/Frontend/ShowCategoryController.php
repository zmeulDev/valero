<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;


class ShowCategoryController extends Controller
{
        public function index($slug)
    {
        // Fetch the category by slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Fetch articles that belong to this category
        $articles = Article::where('category_id', $category->id)->latest()->paginate(4);
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $categories = Category::all();
        $featuredArticle = Article::orderBy('views', 'desc')->first();

        // Return the view with the articles and category data
        return view('layouts.category', compact('articles', 'category', 'popularArticles', 'categories', 'featuredArticle'));
    }
}