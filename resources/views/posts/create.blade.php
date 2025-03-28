@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">Create New Post</h2>
                    <a href="{{ route('posts.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Back to Posts
                    </a>
                </div>
                
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="post-form">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" 
                                id="title" name="title" value="{{ old('title') }}" required>
                            @if ($errors->has('title'))
                                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-bold">Post Type</label>
                                <select class="form-select {{ $errors->has('type') ? 'is-invalid' : '' }}" 
                                    id="type" name="type" required>
                                    <option value="" disabled {{ old('type') ? '' : 'selected' }}>Select post type</option>
                                    @foreach($types ?? ['announcement', 'event', 'sermon', 'news'] as $type)
                                        <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('type'))
                                    <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                                @endif
                            </div>
                            
                            <div class="col-md-6 event-date-field" style="display: none;">
                                <label for="event_date" class="form-label fw-bold">Event Date & Time</label>
                                <input type="datetime-local" 
                                    class="form-control {{ $errors->has('event_date') ? 'is-invalid' : '' }}" 
                                    id="event_date" name="event_date" value="{{ old('event_date') }}">
                                @if ($errors->has('event_date'))
                                    <div class="invalid-feedback">{{ $errors->first('event_date') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="categories" class="form-label fw-bold">Categories</label>
                            <select class="form-select {{ $errors->has('categories') ? 'is-invalid' : '' }}" 
                                id="categories" name="categories[]" multiple>
                                @forelse($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option disabled>No categories available</option>
                                @endforelse
                            </select>
                            @if ($errors->has('categories'))
                                <div class="invalid-feedback">{{ $errors->first('categories') }}</div>
                            @endif
                            <div class="form-text">Hold Ctrl (PC) or Command (Mac) to select multiple categories.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold">Content</label>
                            <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" 
                                id="content" name="content" rows="8" required>{{ old('content') }}</textarea>
                            @if ($errors->has('content'))
                                <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">Featured Image</label>
                            <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" 
                                id="image" name="image" accept="image/*">
                            @if ($errors->has('image'))
                                <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                            @endif
                            <div class="form-text">Optional. Recommended size: 1200x600px, max 2MB.</div>
                        </div>
                        
                        <div class="border rounded p-3 bg-light mb-4">
                            <h5>Publishing Options</h5>
                            
                            @if(auth()->check() && auth()->user()->is_admin)
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="is_featured" 
                                        name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Feature this post on the homepage
                                    </label>
                                </div>
                                
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_approved" 
                                        name="is_approved" value="1" {{ old('is_approved', '1') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_approved">
                                        Approve and publish immediately
                                    </label>
                                </div>
                            @else
                                <div class="alert alert-info mb-0">
                                    <i class="bi bi-info-circle me-2"></i> 
                                    Your post will be reviewed by an administrator before it appears on the site.
                                </div>
                            @endif
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Create Post
                            </button>
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
        
        // Function to toggle event date field based on post type
        function toggleEventDateField() {
            if (typeSelect && eventDateField) {
                eventDateField.style.display = typeSelect.value === 'event' ? 'block' : 'none';
                
                // Only require event_date field when type is event
                const eventDateInput = document.getElementById('event_date');
                if (eventDateInput) {
                    eventDateInput.required = typeSelect.value === 'event';
                }
            }
        }
        
        // Run on page load
        toggleEventDateField();
        
        // Add event listener
        if (typeSelect) {
            typeSelect.addEventListener('change', toggleEventDateField);
        }
    });
</script>
@endpush
@endsection