<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $articleCount = Article::count();
        $userCount = User::count();
        $totalViews = Article::sum('views');
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);
 
        return view('admin.dashboard', compact('articleCount', 'userCount', 'articles', 'totalViews'));
    }
}