<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Display a listing of the posts
    public function index()
    {
        $posts = Post::where('is_published', true)->latest()->paginate(5);
        return view('posts.index', compact('posts'));
    }

    // Show the form for creating a new post
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    // Store a newly created post in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'       => 'required|unique:posts,title',
            'slug'        => 'required|unique:posts,slug',
            'content'     => 'required',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $validatedData['user_id'] = auth()->id();
        $validatedData['is_published'] = $request->has('is_published');

        try {
            $post = Post::create($validatedData);

            if ($post) {
                return redirect()->route('posts.index')->with('success', 'Post created successfully.');
            } else {
                return back()->withErrors('Failed to create post.');
            }
        } catch (\Exception $e) {
            \Log::error('Error creating post: ' . $e->getMessage());
            return back()->withErrors('Error creating post. Please check the logs for more details.');
        }
    }



    // Display the specified post
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // Show the form for editing the specified post
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    // Update the specified post in storage
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title'       => 'required|unique:posts,title,' . $post->id,
            'slug'        => 'required|unique:posts,slug,' . $post->id,
            'content'     => 'required',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($post->image) {
                \Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $validatedData['is_published'] = $request->has('is_published');

        $post->update($validatedData);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    // Remove the specified post from storage
    public function destroy(Post $post)
    {
        if ($post->image) {
            \Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}