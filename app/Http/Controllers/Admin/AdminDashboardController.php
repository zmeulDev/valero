<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $articleCount = Article::count();
        $userCount = User::count();
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);
 
        return view('admin.dashboard', compact('articleCount', 'userCount', 'articles'));
    }
}
