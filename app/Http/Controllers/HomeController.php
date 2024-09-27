<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Facades\SEO;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(4);
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $featuredArticle = Article::latest()->first();
        $categories = Category::all();

        return view('home', compact('featuredArticle', 'articles', 'popularArticles', 'categories'));
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