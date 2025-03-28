@extends('layouts.app')

@section('content')
<div class="container">
    <div class="hero-section bg-primary text-white p-5 mb-4 rounded">
        <h1>Xhamia e Re - Teqe</h1>
        <p class="lead">Njoftimet e reja</p>
    </div>
    
    @if(isset($featured) && $featured->count() > 0)
    <div class="featured-section mb-5">
        <h2 class="mb-4">Featured</h2>
        <div class="row">
            @foreach($featured as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                    @endif
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">{{ ucfirst($post->type) }}</span>
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <div class="row">
        <div class="col-md-8">
            <div class="announcements-section mb-5">
                <h2 class="mb-4">Njoftimet e fundit</h2>
                @if(isset($announcements) && $announcements->count() > 0)
                    @foreach($announcements as $post)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Postuar nga {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</small>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-primary">Lexo më shumë</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-info">Ska njoftime!</div>
                @endif
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="events-section mb-5">
                <h2 class="mb-4">Zhvillime të reja</h2>
                @if(isset($events) && $events->count() > 0)
                    @foreach($events as $event)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="card-text">
                                <i class="bi bi-calendar"></i> {{ $event->event_date->format('M d, Y - h:i A') }}
                            </p>
                            <a href="{{ route('posts.show', $event) }}" class="btn btn-sm btn-outline-primary">Detaje</a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-info">Ska ngjarje të reja.</div>
                @endif
            </div>
            
            <div class="prayer-times-widget card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Kohët e namazeve</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Sabahu</span>
                            <span>5:30 AM</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Dreka</span>
                            <span>1:15 PM</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Ikindija</span>
                            <span>4:45 PM</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Akshami</span>
                            <span>7:20 PM</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Jacia</span>
                            <span>8:45 PM</span>
                        </li>
                    </ul>
                    <div class="mt-3 text-center">
                        <a href="{{ route('prayer-times') }}" class="btn btn-sm btn-success">Më shumë</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection