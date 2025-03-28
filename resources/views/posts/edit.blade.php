@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">Edit Post</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="type" class="form-label">Post Type *</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="" disabled>Select post type</option>
                                    @foreach($types ?? ['announcement', 'event', 'sermon', 'news'] as $type)
                                        <option value="{{ $type }}" {{ old('type', $post->type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 event-date-field" style="{{ $post->type == 'event' ? 'display: block;' : 'display: none;' }}">
                                <label for="event_date" class="form-label">Event Date & Time</label>
                                <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror" id="event_date" name="event_date" value="{{ old('event_date', $post->event_date ? $post->event_date->format('Y-m-d\TH:i') : '') }}">
                                @error('event_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="categories" class="form-label">Categories</label>
                            <select class="form-select @error('categories') is-invalid @enderror" id="categories" name="categories[]" multiple>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ (old('categories', $post->categories->pluck('id')->toArray()) && in_array($category->id, old('categories', $post->categories->pluck('id')->toArray()))) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Hold Ctrl (PC) or Command (Mac) to select multiple categories.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Content *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8" required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Featured Image</label>
                            @if($post->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current image" class="img-thumbnail" style="max-height: 200px;">
                                    <div class="form-text">Current image. Upload a new one to replace it.</div>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional. Recommended size: 1200x600px, max 2MB.</div>
                        </div>
                        
                        @if(auth()->user()->is_admin)
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Feature this post on the homepage</label>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_approved" name="is_approved" value="1" {{ old('is_approved', $post->is_approved) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_approved">Approve this post</label>
                            </div>
                        @elseif(!$post->is_approved)
                            <div class="alert alert-info mb-3">
                                <i class="bi bi-info-circle me-2"></i> Your edited post will need to be reviewed again by an administrator before it appears on the site.
                            </div>
                        @endif
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const eventDateField = document.querySelector('.event-date-field');
        
        function toggleEventDateField() {
            if (typeSelect.value === 'event') {
                eventDateField.style.display = 'block';
            } else {
                eventDateField.style.display = 'none';
            }
        }
        
        toggleEventDateField(); // Run on page load
        typeSelect.addEventListener('change', toggleEventDateField);
    });
</script>
@endpush
@endsection