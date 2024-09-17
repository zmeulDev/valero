<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        
        $articles = Article::latest()->paginate(4);
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $featuredArticle = Article::latest()->first();
        $categories = Category::all();

        return view('home', compact('featuredArticle','articles', 'popularArticles', 'categories'));
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
        $latestArticles = Article::latest()->paginate(8);

        $article = Article::where('slug', $slug)->firstOrFail();
        $article->incrementViews(); // views count
        $wordCount = str_word_count(strip_tags($article->content));
        $readingTime = ceil($wordCount / 200);

        
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $categories = Category::all();
        

        return view('articles.show', compact('article', 'latestArticles', 'popularArticles', 'categories'))->with('read_time', $readingTime);

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

    public function category($slug)
    {
        // Fetch the category by slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Fetch articles that belong to this category
        $articles = Article::where('category_id', $category->id)->latest()->paginate(6);

        // Return the view with the articles and category data
        return view('category.articles', compact('articles', 'category'));
    }

    public function destroyImage(Article $article, $imageId)
{
    // Find the image in the article's images
    $image = $article->images()->where('id', $imageId)->firstOrFail();

    // Delete the image file from storage
    if (Storage::exists('public/' . $image->image_path)) {
        Storage::delete('public/' . $image->image_path);
    }

    // Delete the image from the database
    $image->delete();

    return redirect()->back()->with('success', 'Image deleted successfully.');
}

}
