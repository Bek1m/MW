<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $query = Post::with(['user', 'categories']);
        
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        
        // Only show approved posts to non-admin users
        if (!auth()->check() || !auth()->user()->is_admin) {
            $query->where('is_approved', true);
        }
        
        $posts = $query->latest()->paginate(10);
        
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        \Log::info('PostController create method called', [
            'user' => auth()->user(),
            'is_admin' => auth()->user()->is_admin
        ]);

        $categories = Category::all();
        $types = ['announcement', 'event', 'sermon', 'news'];
        
        return view('posts.create', compact('categories', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|string|in:announcement,event,sermon,news',
            'event_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_approved'] = auth()->user()->is_admin ? true : false;
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('post-images', 'public');
        }
        
        $post = Post::create($validated);
        
        if ($request->has('categories')) {
            $post->categories()->attach($request->categories);
        }
        
        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully! ' . (!$validated['is_approved'] ? 'It will be visible after approval.' : ''));
    }

    public function show(Post $post)
    {
        // If post is not approved and user is not admin or author, abort
        if (!$post->is_approved && (!auth()->check() || (auth()->id() != $post->user_id && !auth()->user()->is_admin))) {
            abort(404);
        }
        
        $post->load(['user', 'categories']);
        
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Check if user is authorized to edit
        if (auth()->id() != $post->user_id && !auth()->user()->is_admin) {
            abort(403);
        }
        
        $categories = Category::all();
        $types = ['announcement', 'event', 'sermon', 'news'];
        
        return view('posts.edit', compact('post', 'categories', 'types'));
    }

    public function update(Request $request, Post $post)
    {
        // Check if user is authorized to update
        if (auth()->id() != $post->user_id && !auth()->user()->is_admin) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|string|in:announcement,event,sermon,news',
            'event_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
        ]);
        
        // Only admins can change approval status
        if (auth()->user()->is_admin && $request->has('is_approved')) {
            $validated['is_approved'] = $request->is_approved ? true : false;
        } elseif (!$post->is_approved) {
            // If post was not approved, mark as unapproved for re-review
            $validated['is_approved'] = false;
        }
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('post-images', 'public');
        }
        
        $post->update($validated);
        
        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        } else {
            $post->categories()->detach();
        }
        
        return redirect()->route('posts.show', $post)
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Check if user is authorized to delete
        if (auth()->id() != $post->user_id && !auth()->user()->is_admin) {
            abort(403);
        }
        
        // Delete image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        
        $post->delete();
        
        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }
    
    public function approve(Post $post)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }
        
        $post->update(['is_approved' => true]);
        
        return back()->with('success', 'Post approved successfully!');
    }
}