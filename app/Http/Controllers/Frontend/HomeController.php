<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(8);
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $featuredArticle = Article::latest()->first();
        $categories = Category::all();

        return view('frontend.home', compact('featuredArticle', 'articles', 'popularArticles', 'categories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($slug)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
}