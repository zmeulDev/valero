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
        $article = Article::with(['category', 'user', 'media'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();
        $article->incrementViews(); // views count

        $latestArticles = Article::with(['category', 'user', 'media'])
            ->published()
            ->orderByDesc('scheduled_at')
            ->orderByDesc('created_at')
            ->paginate(8);
        
        $popularArticles = Article::with(['category', 'user', 'media'])
            ->published()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // Get related articles - improved algorithm
        // First, try to find articles with matching tags
        $relatedArticles = collect();
        
        if ($article->tags_array && count($article->tags_array) > 0) {
            // Find articles with matching tags
            $tagRelated = Article::with(['category', 'user', 'media'])
                ->published()
                ->where('id', '!=', $article->id)
                ->where(function($query) use ($article) {
                    foreach ($article->tags_array as $tag) {
                        $query->orWhere('tags', 'like', '%' . trim($tag) . '%');
                    }
                })
                ->orderBy('views', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
            
            $relatedArticles = $relatedArticles->merge($tagRelated);
        }
        
        // If we don't have enough, add articles from same category
        if ($relatedArticles->count() < 6) {
            $categoryRelated = Article::with(['category', 'user', 'media'])
                ->published()
                ->where('category_id', $article->category_id)
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->orderBy('views', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(6 - $relatedArticles->count())
                ->get();
            
            $relatedArticles = $relatedArticles->merge($categoryRelated);
        }
        
        // If still not enough, add popular articles
        if ($relatedArticles->count() < 6) {
            $popularRelated = Article::with(['category', 'user', 'media'])
                ->published()
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->orderBy('views', 'desc')
                ->orderBy('likes_count', 'desc')
                ->take(6 - $relatedArticles->count())
                ->get();
            
            $relatedArticles = $relatedArticles->merge($popularRelated);
        }
        
        // Limit to 6 articles and remove duplicates
        $relatedArticles = $relatedArticles->unique('id')->take(6)->values();

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
        $latestArticles = Article::with(['category', 'user', 'media'])->latest()->paginate(8);
        $popularArticles = Article::with(['category', 'user', 'media'])->orderBy('views', 'desc')->take(5)->get();
        
        // Get related articles using same improved algorithm
        $relatedArticles = collect();
        
        if ($article->tags_array && count($article->tags_array) > 0) {
            $tagRelated = Article::with(['category', 'user', 'media'])
                ->where('id', '!=', $article->id)
                ->where(function($query) use ($article) {
                    foreach ($article->tags_array as $tag) {
                        $query->orWhere('tags', 'like', '%' . trim($tag) . '%');
                    }
                })
                ->orderBy('views', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
            
            $relatedArticles = $relatedArticles->merge($tagRelated);
        }
        
        if ($relatedArticles->count() < 6) {
            $categoryRelated = Article::with(['category', 'user', 'media'])
                ->where('category_id', $article->category_id)
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->orderBy('views', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(3 - $relatedArticles->count())
                ->get();
            
            $relatedArticles = $relatedArticles->merge($categoryRelated);
        }
        
        if ($relatedArticles->count() < 6) {
            $popularRelated = Article::with(['category', 'user', 'media'])
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->orderBy('views', 'desc')
                ->orderBy('likes_count', 'desc')
                ->take(3 - $relatedArticles->count())
                ->get();
            
            $relatedArticles = $relatedArticles->merge($popularRelated);
        }
        
        $relatedArticles = $relatedArticles->unique('id')->take(3)->values();
        
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

}
