@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card border-primary h-100">
            <div class="card-body text-center">
                <h1 class="display-4 text-primary mb-2">{{ $stats['total_posts'] ?? 0 }}</h1>
                <h5 class="card-title">Total Posts</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-warning h-100">
            <div class="card-body text-center">
                <h1 class="display-4 text-warning mb-2">{{ $stats['pending_posts'] ?? 0 }}</h1>
                <h5 class="card-title">Pending Posts</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-success h-100">
            <div class="card-body text-center">
                <h1 class="display-4 text-success mb-2">{{ $stats['total_users'] ?? 0 }}</h1>
                <h5 class="card-title">Users</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-info h-100">
            <div class="card-body text-center">
                <h1 class="display-4 text-info mb-2">{{ $stats['total_categories'] ?? 0 }}</h1>
                <h5 class="card-title">Categories</h5>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Posts</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recent_posts ?? [] as $post)
                                <tr>
                                    <td>{{ Str::limit($post->title, 30) }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td><span class="badge bg-primary">{{ ucfirst($post->type) }}</span></td>
                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No posts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-primary">View All Posts</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pending Approval</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pending_posts ?? [] as $post)
                                <tr>
                                    <td>{{ Str::limit($post->title, 30) }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td><span class="badge bg-primary">{{ ucfirst($post->type) }}</span></td>
                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary">View</a>
                                            <form action="{{ route('posts.approve', $post) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No pending posts.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.pending-posts') }}" class="btn btn-sm btn-primary">View All Pending Posts</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('posts.create') }}" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle me-2"></i> Create Post
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-success w-100">
                            <i class="bi bi-people me-2"></i> Manage Users
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.categories') }}" class="btn btn-info w-100 text-white">
                            <i class="bi bi-tags me-2"></i> Manage Categories
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.pending-posts') }}" class="btn btn-warning w-100">
                            <i class="bi bi-hourglass-split me-2"></i> Pending Posts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection