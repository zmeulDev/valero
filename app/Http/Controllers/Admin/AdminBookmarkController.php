<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AdminBookmarkController extends Controller
{
    /**
     * Display a listing of bookmarks.
     */
    public function index(Request $request)
    {
        $query = Bookmark::with('user');

        // Handle search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('link', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Handle category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $bookmarks = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        
        // Get unique categories for filter
        $categories = Bookmark::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('admin.bookmarks.index', compact('bookmarks', 'categories'));
    }

    /**
     * Show the form for creating a new bookmark.
     */
    public function create()
    {
        // Get existing categories for dropdown
        $categories = Bookmark::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('admin.bookmarks.create', compact('categories'));
    }

    /**
     * Store a newly created bookmark in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|url|max:1000',
            'notes' => 'nullable|string|max:5000',
            'category' => 'nullable|string|max:100',
            'new_category' => 'nullable|string|max:100',
        ]);

        // If category is "__new__", use the new_category value instead
        if (isset($validated['category']) && $validated['category'] === '__new__' && !empty($validated['new_category'])) {
            $validated['category'] = $validated['new_category'];
        }

        // Remove the new_category field as it's not part of the model
        unset($validated['new_category']);

        $validated['user_id'] = Auth::id();

        Bookmark::create($validated);

        Cache::forget('bookmarks_all');

        return redirect()
            ->route('admin.bookmarks.index')
            ->with('success', __('admin.bookmarks.created_successfully'));
    }

    /**
     * Show the form for editing the specified bookmark.
     */
    public function edit(Bookmark $bookmark)
    {
        // Get existing categories for dropdown
        $categories = Bookmark::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('admin.bookmarks.edit', compact('bookmark', 'categories'));
    }

    /**
     * Update the specified bookmark in storage.
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|url|max:1000',
            'notes' => 'nullable|string|max:5000',
            'category' => 'nullable|string|max:100',
            'new_category' => 'nullable|string|max:100',
        ]);

        // If category is "__new__", use the new_category value instead
        if (isset($validated['category']) && $validated['category'] === '__new__' && !empty($validated['new_category'])) {
            $validated['category'] = $validated['new_category'];
        }

        // Remove the new_category field as it's not part of the model
        unset($validated['new_category']);

        $bookmark->update($validated);

        Cache::forget('bookmarks_all');

        return redirect()
            ->route('admin.bookmarks.index')
            ->with('success', __('admin.bookmarks.updated_successfully'));
    }

    /**
     * Remove the specified bookmark from storage.
     */
    public function destroy(Bookmark $bookmark)
    {
        $bookmark->delete();

        Cache::forget('bookmarks_all');

        return redirect()
            ->route('admin.bookmarks.index')
            ->with('success', __('admin.bookmarks.deleted_successfully'));
    }

    /**
     * Get all bookmarks for API/AJAX requests (for article options tab).
     */
    public function getAllBookmarks(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);
        
        $query = Bookmark::orderBy('category')->orderBy('title');
        
        // If category filter is provided
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        // If search query is provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('link', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        
        $bookmarks = $query->select(['id', 'title', 'link', 'notes', 'category'])
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $bookmarks->items(),
            'current_page' => $bookmarks->currentPage(),
            'last_page' => $bookmarks->lastPage(),
            'per_page' => $bookmarks->perPage(),
            'total' => $bookmarks->total(),
            'from' => $bookmarks->firstItem(),
            'to' => $bookmarks->lastItem(),
        ]);
    }
}
