<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');

        $articlesQuery = Article::with(['user', 'category'])
            ->when($query, function ($q) use ($query) {
                return $q->where('title', 'LIKE', "%{$query}%")
                         ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->when($category, function ($q) use ($category) {
                return $q->where('category_id', $category);
            })
            ->latest(); // Order by latest first

        $articles = $articlesQuery->paginate(10);

        return response()->json([
            'data' => $articles->items(),
            'links' => $articles->links()->toHtml(),
            'current_page' => $articles->currentPage(),
            'last_page' => $articles->lastPage(),
        ]);
    }

    public function categories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
}