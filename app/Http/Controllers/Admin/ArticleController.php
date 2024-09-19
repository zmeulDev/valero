<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Display a listing of the articles.
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);

        return view('admin.articles.index', compact('articles'));
    }

public function create()
{
    $categories = Category::all();
    return view('admin.articles.create', compact('categories'));
}

    // Store a newly created article in storage.
    public function store(Request $request)
    {
        // Validate the request data.
        $validated = $request->validate([
            'title'           => 'required|unique:articles|max:255',
            'excerpt'         => 'nullable|max:255',
            'content'         => 'required',
            'category_id' => 'required|exists:categories,id',
            'featured_image'  => 'nullable|image|max:2048',
            'scheduled_at'    => 'nullable|date',
            'gallery_images.*'=> 'image|max:2048',
        ]);

        // Create a new article instance.
        $article = new Article();
        $article->user_id = auth()->id();
        $article->title = $validated['title'];
        $article->slug = Str::slug($validated['title']);
        $article->excerpt = $validated['excerpt'] ?? null;
        $article->category_id = $request->category_id; 
        $article->content = $validated['content'];
        $article->scheduled_at = $validated['scheduled_at'] ?? null;

        // Handle the featured image upload.
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            $featuredImagePath = $featuredImage->store('images', 'public');
            $article->featured_image = $featuredImagePath;
        }

        // Save the article to the database.
        $article->save();

        // Handle the gallery images upload.
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galleryImage) {
                $galleryImagePath = $galleryImage->store('images', 'public');

                $image = new Image();
                $image->article_id = $article->id;
                $image->image_path = $galleryImagePath;
                $image->save();
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    // Display the specified article.
    public function show(Article $article)
    {
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $categories = Category::all();

        return view('admin.articles.show', compact('article', 'popularArticles', 'categories'));
    }

    // Show the form for editing the specified article.
    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    // Update the specified article in storage.
    public function update(Request $request, Article $article)
    {
        // Validate the request data.
        $validated = $request->validate([
            'title'           => 'required|max:255|unique:articles,title,' . $article->id,
            'excerpt'         => 'nullable|max:255',
            'content'         => 'required',
            
            'featured_image'  => 'nullable|image|max:2048',
            'scheduled_at'    => 'nullable|date',
            'gallery_images.*'=> 'image|max:2048',
        ]);

        $article->title = $validated['title'];
        $article->slug = Str::slug($validated['title']);
        $article->excerpt = $validated['excerpt'] ?? null;
        $article->content = $validated['content'];
        $article->category_id = $request->category_id; 
        $article->scheduled_at = $validated['scheduled_at'] ?? null;

        // Handle the featured image upload.
        if ($request->hasFile('featured_image')) {
            // Delete the old featured image if it exists.
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }

            $featuredImage = $request->file('featured_image');
            $featuredImagePath = $featuredImage->store('images', 'public');
            $article->featured_image = $featuredImagePath;
        }

        // Save the updated article to the database.
        $article->save();

        // Handle the gallery images upload.
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galleryImage) {
                $galleryImagePath = $galleryImage->store('images', 'public');

                $image = new Image();
                $image->article_id = $article->id;
                $image->image_path = $galleryImagePath;
                $image->save();
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    // Remove the specified article from storage.
    public function destroy(Article $article)
    {
        // Delete the featured image if it exists.
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        // Delete all gallery images associated with the article.
        foreach ($article->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete the article.
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }

    // Remove a specific gallery image.
    public function destroyImage($id)
    {
        $image = Image::findOrFail($id);

        // Delete the image file.
        Storage::disk('public')->delete($image->image_path);

        // Delete the image record from the database.
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}