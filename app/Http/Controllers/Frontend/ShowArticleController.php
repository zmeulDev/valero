<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShowArticleController extends Controller
{
    public function index($slug)
    {  
        $article = Article::where('slug', $slug)
            ->where(function($query) {
                $query->whereNull('scheduled_at')
                      ->orWhere('scheduled_at', '<=', now());
            })->firstOrFail();
        $article->incrementViews(); // views count

        $latestArticles = Article::where(function($query) {
            $query->whereNull('scheduled_at')
                  ->orWhere('scheduled_at', '<=', now());
        })->latest()->paginate(8);
        
        $popularArticles = Article::where(function($query) {
                $query->whereNull('scheduled_at')
                      ->orWhere('scheduled_at', '<=', now());
            })
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $relatedArticles = Article::where(function($query) {
                $query->whereNull('scheduled_at')
                      ->orWhere('scheduled_at', '<=', now());
            })
            ->orderBy('category_id', 'desc')
            ->take(3)
            ->get();

        $categories = Category::all();

        return view('layouts.article', compact(
            'article', 
            'latestArticles', 
            'popularArticles', 
            'relatedArticles', 
            'categories'
        ));
    }

    public function create()
    {
    }

    public function store()
    {
    }


    public function show()
    {
    }

    public function edit()
{
}


    public function update()
    {
       
    }

    public function destroy()
    {
        //
    }

    public function like(Request $request, Article $article)
    {
        try {
            if ($request->liked) {
                $article->increment('likes_count');
            } else {
                $article->decrement('likes_count');
            }
            
            return response()->json([
                'success' => true,
                'likes_count' => $article->likes_count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update like status'
            ], 500);
        }
    }
}
