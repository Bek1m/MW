@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(!$post->is_approved)
                <div class="alert alert-warning mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    This post is currently pending approval and is not visible to the public.
                    @if(auth()->user()->is_admin)
                        <form action="{{ route('posts.approve', $post) }}" method="POST" class="d-inline ms-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success">Approve Now</button>
                        </form>
                    @endif
                </div>
            @endif
            
            <div class="card shadow-sm">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="max-height: 400px; object-fit: cover;">
                @endif
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="badge bg-primary">{{ ucfirst($post->type) }}</span>
                            @foreach($post->categories as $category)
                                <span class="badge bg-secondary">{{ $category->name }}</span>
                            @endforeach
                        </div>
                        
                        @if(auth()->check() && (auth()->user()->is_admin || auth()->id() == $post->user_id))
                            <div>
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this post?')">
                                        <i class="bi bi-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    
                    <h1 class="card-title mb-3">{{ $post->title }}</h1>
                    
                    <div class="d-flex mb-4 text-muted">
                        <div class="me-3">
                            <i class="bi bi-person me-1"></i> {{ $post->user->name }}
                        </div>
                        <div class="me-3">
                            <i class="bi bi-calendar me-1"></i> {{ $post->created_at->format('M d, Y') }}
                        </div>
                        @if($post->type == 'event' && $post->event_date)
                            <div>
                                <i class="bi bi-calendar-event me-1"></i> {{ $post->event_date->format('M d, Y - h:i A') }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="post-content mb-4">
                        {!! $post->content !!}
                    </div>
                    
                    @if($post->type == 'event' && $post->event_date)
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Event Details</h5>
                                <p class="mb-2"><strong>Date:</strong> {{ $post->event_date->format('F d, Y') }}</p>
                                <p class="mb-2"><strong>Time:</strong> {{ $post->event_date->format('h:i A') }}</p>
                                <p class="mb-0"><strong>Location:</strong> Mosque Main Hall</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left me-1"></i> Back to Posts
                            </a>
                        </div>
                        
                        <div class="d-flex">
                            <a href="#" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-share me-1"></i> Share
                            </a>
                            <a href="#" class="btn btn-outline-secondary">
                                <i class="bi bi-printer me-1"></i> Print
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <h4>Related Posts</h4>
                <div class="row">
                    @foreach(App\Models\Post::where('is_approved', true)
                        ->where('id', '!=', $post->id)
                        ->where('type', $post->type)
                        ->latest()
                        ->take(3)
                        ->get() as $relatedPost)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @if($relatedPost->image)
                                    <img src="{{ asset('storage/' . $relatedPost->image) }}" class="card-img-top" alt="{{ $relatedPost->title }}" style="height: 160px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($relatedPost->title, 40) }}</h5>
                                    <p class="card-text">{{ Str::limit(strip_tags($relatedPost->content), 80) }}</p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="{{ route('posts.show', $relatedPost) }}" class="btn btn-sm btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection