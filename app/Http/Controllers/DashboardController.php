<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with a list of posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all published posts with pagination
        $posts = Post::where('is_published', true)->latest()->paginate(5);

        // Pass the $posts variable to the 'dashboard' view
        return view('dashboard', compact('posts'));
    }
}