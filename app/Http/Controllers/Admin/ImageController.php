<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'images.*' => 'required|image|max:2048',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images', 'public');
                $article->images()->create(['image_path' => $imagePath]);
            }
        }

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $featuredImagePath = $request->file('featured_image')->store('images', 'public');
            $article->update(['featured_image' => $featuredImagePath]);
        }

        return back()->with('success', 'Image(s) uploaded successfully.');
    }

    public function destroy(Article $article, Image $image)
    {
        if (Auth::user()->id !== $article->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    public function updateFeatured(Request $request, Article $article)
    {
        $request->validate([
            'featured_image' => 'required|image|max:2048',
        ]);

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $featuredImagePath = $request->file('featured_image')->store('images', 'public');
        $article->update(['featured_image' => $featuredImagePath]);

        return back()->with('success', 'Featured image updated successfully.');
    }
}