<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminPlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::withCount('articles')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.playlists.index', compact('playlists'));
    }

    public function create()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view('admin.playlists.create', compact('articles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255|unique:playlists',
            'description' => 'nullable|string',
            'articles' => 'nullable|array',
            'articles.*' => 'exists:articles,id'
        ]);

        $playlist = new Playlist([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'user_id' => auth()->id(),
            'slug' => Str::slug($validated['title'])
        ]);

        $playlist->save();

        if ($request->has('articles')) {
            // Attach in the order of the array
            $syncData = [];
            foreach ($validated['articles'] as $index => $articleId) {
                $syncData[$articleId] = ['order' => $index + 1];
            }
            $playlist->articles()->sync($syncData);
        }

        return redirect()->route('admin.playlists.index')
            ->with('success', 'Playlist created successfully.');
    }

    public function edit(Playlist $playlist)
    {
        $playlist->load(['articles']); // articles are ordered by pivot scope in Model
        $allArticles = Article::orderBy('created_at', 'desc')->get();
        return view('admin.playlists.edit', compact('playlist', 'allArticles'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255', Rule::unique('playlists')->ignore($playlist->id)],
            'description' => 'nullable|string',
            'articles' => 'nullable|array',
            'articles.*' => 'exists:articles,id'
        ]);

        $playlist->title = $validated['title'];
        $playlist->description = $validated['description'];
        $playlist->slug = Str::slug($validated['title']);
        $playlist->save();

        if ($request->has('articles')) {
            $syncData = [];
            foreach ($validated['articles'] as $index => $articleId) {
                $syncData[$articleId] = ['order' => $index + 1];
            }
            $playlist->articles()->sync($syncData);
        } else {
            $playlist->articles()->detach();
        }

        return redirect()->route('admin.playlists.index')
            ->with('success', 'Playlist updated successfully.');
    }

    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return redirect()->route('admin.playlists.index')
            ->with('success', 'Playlist deleted successfully.');
    }
}
