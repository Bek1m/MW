<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured posts
        $featured = Post::with(['user', 'categories'])
            ->where('is_approved', true)
            ->where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();
            
        // Get recent announcements
        $announcements = Post::with(['user', 'categories'])
            ->where('is_approved', true)
            ->where('type', 'announcement')
            ->latest()
            ->take(5)
            ->get();
            
        // Get upcoming events
        $events = Post::with(['user', 'categories'])
            ->where('is_approved', true)
            ->where('type', 'event')
            ->whereNotNull('event_date')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(5)
            ->get();
            
        return view('home', compact('featured', 'announcements', 'events'));
    }
    
    public function contact()
    {
        return view('contact');
    }
    
    public function prayerTimes()
    {
        return view('prayer-times');
    }
}