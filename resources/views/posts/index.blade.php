@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>{{ request('type') ? ucfirst(request('type')) . 's' : 'All Posts' }}</h1>
                @auth
                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Krijo Postim
                </a>
                @endauth
            </div>
            
            <div class="mb-4">
                <form action="{{ route('posts.index') }}" method="GET" class="d-flex">
                    <div class="input-group me-2">
                        <input type="text" class="form-control" placeholder="Kërko..." name="search" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <select class="form-select" name="type" onchange="this.form.submit()">
                        <option value="">Llojet</option>
                        <option value="announcement" {{ request('type') == 'announcement' ? 'selected' : '' }}>Njoftimet</option>
                        <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Eventet</option>
                        <option value="news" {{ request('type') == 'news' ? 'selected' : '' }}>Lajmet</option>
                    </select>
                </form>
            </div>

            @if($posts->isEmpty())
                <div class="alert alert-info">
                    Nuk ka postime. {{ auth()->check() ? 'Posto!' : 'Kthehuni më vonë' }}
                </div>
            @else
                @foreach($posts as $post)
                    <div class="card mb-4">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ ucfirst($post->type) }}</span>
                                @foreach($post->categories as $category)
                                    <span class="badge bg-secondary">{{ $category->name }}</span>
                                @endforeach
                            </div>
                            <p class="card-text">{{ Str::limit(strip_tags($post->content), 200) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    <span>Nga {{ $post->user->name }} në {{ $post->created_at->format('M d, Y') }}</span>
                                    @if($post->type == 'event' && $post->event_date)
                                        <br>
                                        <span><i class="bi bi-calendar-event me-1"></i>{{ $post->event_date->format('M d, Y - h:i A') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Më shumë</a>
                            </div>

                            @if(auth()->check() && (auth()->user()->is_admin || auth()->id() == $post->user_id))
                                <div class="mt-3 d-flex">
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                    
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Fshij</button>
                                    </form>
                                    
                                    @if(auth()->user()->is_admin && !$post->is_approved)
                                        <form action="{{ route('posts.approve', $post) }}" method="POST" class="ms-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">Mirato</button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Filtro nga tipet</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('posts.index') }}" class="list-group-item list-group-item-action {{ !request('type') ? 'active' : '' }}">
                            Postimet
                        </a>
                        <a href="{{ route('posts.index', ['type' => 'announcement']) }}" class="list-group-item list-group-item-action {{ request('type') == 'announcement' ? 'active' : '' }}">
                            Njoftimet
                        </a>
                        <a href="{{ route('posts.index', ['type' => 'event']) }}" class="list-group-item list-group-item-action {{ request('type') == 'event' ? 'active' : '' }}">
                            Eventet
                        </a>
                        <a href="{{ route('posts.index', ['type' => 'news']) }}" class="list-group-item list-group-item-action {{ request('type') == 'news' ? 'active' : '' }}">
                            Lajmet
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Kategoritë</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach(App\Models\Category::withCount('posts')->get() as $category)
                            <a href="{{ route('posts.index', ['category_id' => $category->id]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                {{ $category->name }}
                                <span class="badge bg-primary rounded-pill">{{ $category->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Postimet</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach(App\Models\Post::where('is_approved', true)->latest()->take(5)->get() as $recentPost)
                            <li class="list-group-item px-0">
                                <a href="{{ route('posts.show', $recentPost) }}" class="text-decoration-none">{{ $recentPost->title }}</a>
                                <p class="text-muted small mb-0">{{ $recentPost->created_at->format('M d, Y') }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection