<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class SearchController extends Controller
{
    /**
     * Handle the search request and display results.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
           // Validate the search query
           $request->validate([
               'query' => 'required|string|max:255',
               'category' => 'nullable|integer|exists:categories,id', // If implementing category filter
           ]);

           $query = $request->input('query');
           $category = $request->input('category');

           // Initialize the query builder
           $articlesQuery = Article::query();

           // Apply search terms
           $articlesQuery->where(function($q) use ($query) {
               $q->where('title', 'LIKE', "%{$query}%")
                 ->orWhere('content', 'LIKE', "%{$query}%");
           });

           // Apply category filter if selected (Optional)
           if ($category) {
               $articlesQuery->where('category_id', $category);
           }

           // Execute the query with pagination
           $articles = $articlesQuery->paginate(10)->appends([
               'query' => $query,
               'category' => $category,
           ]);

           return view('search.results', compact('articles', 'query', 'category'));
       }
}