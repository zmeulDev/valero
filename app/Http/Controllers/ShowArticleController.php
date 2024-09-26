<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Facades\SEO;

class ShowArticleController extends Controller
{
    public function index()
    {  
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }


    public function show($slug)
    {
        $latestArticles = Article::latest()->paginate(8);

        $article = Article::where('slug', $slug)->firstOrFail();
        $article->incrementViews(); // views count
        
        $wordCount = str_word_count(strip_tags($article->content));
        $readingTime = ceil($wordCount / 200);

        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $categories = Category::all();

        return view('layouts.article', compact('article', 'latestArticles', 'popularArticles', 'categories', 'readingTime'));
    }

    public function edit($id)
{
}


    public function update(Request $request, $id)
    {
       
    }

    public function destroy(Article $article)
    {
        //
    }

    public function category($slug)
    {
        // Fetch the category by slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Fetch articles that belong to this category
        $articles = Article::where('category_id', $category->id)->latest()->paginate(6);

        // Return the view with the articles and category data
        return view('category.articles', compact('articles', 'category'));
    }
}