<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::withCount('articles')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('frontend.playlists.index', [
            'playlists' => $playlists,
            'categories' => Category::all(),
            'popularArticles' => Article::published()->orderBy('views', 'desc')->take(5)->get()
        ]);
    }

    public function show(Playlist $playlist)
    {
        $playlist->load([
            'articles' => function ($query) {
                $query->with(['category', 'user', 'media']);
            }
        ]);

        return view('frontend.playlists.show', [
            'playlist' => $playlist,
            'categories' => Category::all(),
            'popularArticles' => Article::published()->orderBy('views', 'desc')->take(5)->get()
        ]);
    }
}
