<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ImageController;
use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use RalphJSmit\Laravel\SEO\Support\SEOData;


class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:articles|max:255',
            'excerpt' => 'nullable|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'scheduled_at' => 'nullable|date',
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $article = new Article($validated);
        $article->user_id = auth()->id();
        $article->title = $validated['title'];
        $article->slug = Str::slug($validated['title']);
        $article->excerpt = $validated['excerpt'] ?? null;
        $article->category_id = $request->category_id;
        $article->content = $validated['content'];
        $article->scheduled_at = $validated['scheduled_at'] ?? null;

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('images', 'public');
            $article->featured_image = $path;
        }

        $article->save();

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('images', 'public');
        $article->images()->create(['image_path' => $path]);
            }
        }

        $article->seo->update([
            'title' => $article->title,
            'description' => $article->excerpt,
            'image' => $article->featured_image,
            'author' => auth()->user()->name,
            'robots' => 'index, follow',
            'canonical_url' => route('articles.index', $article->slug),
        ]);
        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $categories = Category::all();
        $wordCount = str_word_count(strip_tags($article->content));
        $readingTime = ceil($wordCount / 200);

        return view('admin.articles.show', compact('article', 'popularArticles', 'categories', 'readingTime'));
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'nullable|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
        ]);

        $article->update($validatedData);

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('images', 'public');
            $article->featured_image = $path;
            $article->save();
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('images', 'public');
                $article->images()->create(['image_path' => $path]);
            }
        }

        $article->seo->updateOrCreate([
            'model_id' => $article->id,
            'model_type' => Article::class,
            'title' => $article->title,
            'description' => $article->excerpt,
            'image' => $article->featured_image,
            'author' => auth()->user()->name,
            'robots' => 'index, follow',
            'canonical_url' => route('articles.index', $article->slug),
        ]);

        return redirect()->route('admin.articles.edit', $article)->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        foreach ($article->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $article->delete();
        $article->seo->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
}