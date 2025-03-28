<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }
    
    public function dashboard()
    {
        $stats = [
            'total_posts' => Post::count(),
            'pending_posts' => Post::where('is_approved', false)->count(),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
        ];
        
        $recent_posts = Post::with('user')->latest()->take(5)->get();
        $pending_posts = Post::with('user')->where('is_approved', false)->latest()->take(10)->get();
        
        return view('admin.dashboard', compact('stats', 'recent_posts', 'pending_posts'));
    }
    
    public function users()
    {
        $users = User::withCount('posts')->paginate(15);
        return view('admin.users', compact('users'));
    }
    
    public function categories()
    {
        $categories = Category::withCount('posts')->paginate(15);
        return view('admin.categories', compact('categories'));
    }
    
    public function pendingPosts()
    {
        $posts = Post::with('user')
            ->where('is_approved', false)
            ->latest()
            ->paginate(15);
            
        return view('admin.pending-posts', compact('posts'));
    }
}