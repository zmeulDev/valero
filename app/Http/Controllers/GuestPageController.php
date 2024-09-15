<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Category;

class GuestPageController extends Controller
{
    /**
     * Show the guest page with posts.
     *
     * @return \Illuminate\View\View
     */
    public function showGuestPage()
    {
        // Fetch the published posts, ordered by the latest
        $posts = Post::where('is_published', true)->latest()->paginate(5);

        $categories = Category::withCount(['posts' => function ($query) {
            $query->where('is_published', true);
        }])->get();

        // Return the guest page view with the posts
        return view('guest', compact('posts', 'categories'));
    }
}