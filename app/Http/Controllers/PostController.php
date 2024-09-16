<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Purifier;

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
        'content'     => 'required', // Content can now contain HTML
        'category_id' => 'required|exists:categories,id',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    

    // Handle image upload if present
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $validatedData['image'] = $imagePath;
    }

    // Add additional fields to the validated data
    $validatedData['user_id'] = auth()->id();
    $validatedData['is_published'] = $request->has('is_published');
    $validatedData['content'] = Purifier::clean($request->content);

    // Store the post
    try {
        \DB::beginTransaction(); // Start a transaction

        $post = Post::create($validatedData);

        \DB::commit(); // Commit transaction if all goes well

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');

    } catch (\Exception $e) {
        \DB::rollBack(); // Roll back transaction on failure
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
        'content'     => 'required', // Content will have HTML
        'category_id' => 'required|exists:categories,id',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle image upload and delete old image if necessary
    if ($request->hasFile('image')) {
        if ($post->image) {
            \Storage::disk('public')->delete($post->image);
        }
        $imagePath = $request->file('image')->store('images', 'public');
        $validatedData['image'] = $imagePath;
    }

    $validatedData['is_published'] = $request->has('is_published');
    $validatedData['content'] = Purifier::clean($request->content);

    // Update the post
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