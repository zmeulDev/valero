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
        })->orderByRaw('CASE WHEN scheduled_at IS NOT NULL THEN scheduled_at ELSE created_at END DESC')->paginate(8);
        
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
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest()
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

    /**
     * Preview a scheduled article (admin only)
     */
    public function preview($slug)
    {
        // Find the article without scheduling restrictions
        $article = Article::where('slug', $slug)->firstOrFail();
        
        // Get related data without scheduling restrictions
        $latestArticles = Article::latest()->paginate(8);
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();
        $categories = Category::all();

        // Add a preview banner to the view
        $isPreview = true;

        return view('layouts.article', compact(
            'article', 
            'latestArticles', 
            'popularArticles', 
            'relatedArticles', 
            'categories',
            'isPreview'
        ));
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
}
