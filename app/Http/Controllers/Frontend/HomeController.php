<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(8);
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $featuredArticle = Article::latest()->first();

        return view('frontend.home', compact(
            'featuredArticle', 
            'articles', 
            'popularArticles'
        ));
    }
}