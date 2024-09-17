<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        
        $articles = Article::latest()->paginate(4);
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $featuredArticle = Article::latest()->first();

        return view('home', compact('featuredArticle','articles', 'popularArticles'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'excerpt' => 'nullable|max:255',
        'content' => 'required',
        'featured_image' => 'nullable|image|max:2048',
        'gallery_images.*' => 'image|max:2048',
        'scheduled_at' => 'nullable|date',
    ]);

    // Create the article
    $article = new Article();
    $article->user_id = auth()->id(); // Assign the authenticated user as the author
    $article->title = $validated['title'];
    $article->slug = Str::slug($validated['title']);
    $article->excerpt = $validated['excerpt'];
    $article->content = $validated['content'];
    $article->scheduled_at = $validated['scheduled_at'];

    // Handle featured image upload
    if ($request->hasFile('featured_image')) {
        $article->featured_image = $request->file('featured_image')->store('images', 'public');
    }

    // Save the article
    $article->save();

    // Handle gallery images upload
    if ($request->hasFile('gallery_images')) {
        foreach ($request->file('gallery_images') as $image) {
            $imagePath = $image->store('images', 'public');
            $article->images()->create(['image_path' => $imagePath]);
        }
    }

    return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
}


    public function show($slug)
    {
        $articles = Article::latest()->paginate(8);
        $article = Article::where('slug', $slug)->firstOrFail();
        $article->incrementViews();
        return view('articles.show', compact('article', 'articles'));
    }

    public function edit($id)
{
    $article = Article::findOrFail($id);
    return view('admin.articles.edit', compact('article'));
}


public function update(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'excerpt' => 'nullable|max:255',
        'content' => 'required',
        'featured_image' => 'nullable|image|max:2048',
        'gallery_images.*' => 'image|max:2048',
        'scheduled_at' => 'nullable|date',
    ]);

    $article = Article::findOrFail($id);
    $article->title = $validated['title'];
    $article->excerpt = $validated['excerpt'];
    $article->content = $validated['content'];
    $article->scheduled_at = $validated['scheduled_at'];

    // Handle featured image upload
    if ($request->hasFile('featured_image')) {
        if ($article->featured_image) {
            Storage::delete('public/' . $article->featured_image);
        }
        $article->featured_image = $request->file('featured_image')->store('images', 'public');
    }

    // Save the article
    $article->save();

    // Handle gallery images upload
    if ($request->hasFile('gallery_images')) {
        foreach ($request->file('gallery_images') as $image) {
            $imagePath = $image->store('images', 'public');
            $article->images()->create(['image_path' => $imagePath]);
        }
    }

    return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
