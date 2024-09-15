<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class DashboardController extends Controller
{

    public function index()
    {
        // dd('DashboardController@index');
        // Retrieve all published posts with pagination
        $posts = Post::where('is_published', true)->latest()->paginate(5);

        // Retrieve all categories with the count of published posts
        $categories = Category::withCount(['posts' => function ($query) {
            $query->where('is_published', true);
        }])->get();

        // Pass the $posts and $categories variables to the 'dashboard' view
        return view('dashboard', compact('posts', 'categories'));
        
    }
}