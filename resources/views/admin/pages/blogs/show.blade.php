@extends('admin.layouts.master')

@section('title', $blog->title . ' - Details')

@section('content')
<style>
    .show-wrapper {
        background-color: #f4f6f9;
        min-height: calc(100vh - 60px);
    }
    .blog-cover {
        max-height: 400px;
        object-fit: cover;
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .info-label {
        font-weight: 600;
        color: #64748b;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.1rem;
    }
    .blog-content p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #334155;
        margin-bottom: 1.5rem;
    }
</style>

<div class="p-4 show-wrapper">
    <!-- Breadcrumb & Title Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="text-muted small mb-1">
                <a href="{{ route('admin.dashboard.index') }}" class="text-decoration-none text-muted">Dashboard</a> 
                <span class="mx-1">/</span> 
                <a href="{{ route('admin.blogs.index') }}" class="text-decoration-none text-muted">Blogs</a> 
                <span class="mx-1">/</span> 
                <span class="text-primary font-medium">{{ Str::limit($blog->title, 30) }}</span>
            </div>
            <h3 class="fw-bold mb-0 text-dark">
                📝 Blog Details
            </h3>
        </div>
        <div>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary rounded-pill px-3 me-2">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
                <i class="bi bi-pencil me-1"></i> Edit Blog
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Side: Blog Content -->
        <div class="col-lg-8">
            <!-- Blog Cover Image -->
            <div class="card border-0 rounded-4 shadow-sm mb-4">
                <div class="card-body p-4">
                    @if($blog->image)
                        <img src="{{ Str::startsWith($blog->image, 'http') ? $blog->image : asset('storage/' . $blog->image) }}" class="blog-cover mb-4" alt="{{ $blog->title }}">
                    @else
                        <div class="bg-light rounded-4 d-flex flex-column align-items-center justify-content-center py-5 border border-dashed text-muted mb-4" style="height: 250px;">
                            <i class="bi bi-image fs-1 mb-2"></i>
                            <span>No cover image uploaded</span>
                        </div>
                    @endif

                    <h1 class="fw-bold text-dark mb-3">{{ $blog->title }}</h1>
                    
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4 text-muted small border-bottom pb-3">
                        <span><i class="bi bi-calendar-event me-1"></i> {{ $blog->date ?? $blog->created_at->format('M d, Y') }}</span>
                        <span><i class="bi bi-tag me-1"></i> <span class="badge bg-primary bg-opacity-10 text-primary">{{ $blog->category }}</span></span>
                        @if($blog->read_time)
                            <span><i class="bi bi-clock me-1"></i> {{ $blog->read_time }}</span>
                        @endif
                    </div>

                    <!-- Excerpt Panel -->
                    <div class="p-3 bg-light rounded-3 mb-4 border-start border-primary border-4 text-secondary italic" style="font-size: 1.1rem; font-style: italic;">
                        "{{ $blog->excerpt }}"
                    </div>

                    <!-- Body Content -->
                    <div class="blog-content">
                        @if(is_array($blog->content))
                            @foreach($blog->content as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        @else
                            @foreach(explode(PHP_EOL, $blog->content) as $paragraph)
                                @if(trim($paragraph))
                                    <p>{{ trim($paragraph) }}</p>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Details & Stats Panel -->
        <div class="col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm mb-4 sticky-top" style="top: 24px; z-index: 10;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-dark-emphasis">
                        <i class="bi bi-info-circle text-primary me-2"></i>Blog Info
                    </h5>

                    <!-- Properties Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <div class="p-3 bg-light rounded-3">
                                <div class="info-label"><i class="bi bi-link-45deg me-1"></i> Slug</div>
                                <div class="info-value text-break text-muted small">{{ $blog->slug }}</div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 col-12 w-100">
                                <div class="info-label"><i class="bi bi-hash me-1"></i> Database ID</div>
                                <div class="info-value">#{{ $blog->id }}</div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 col-12 w-100">
                                <div class="info-label"><i class="bi bi-calendar-check me-1"></i> Date</div>
                                <div class="info-value text-nowrap" style="font-size: 0.95rem;">{{ $blog->date ?? $blog->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- Actions -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary btn-lg rounded-pill fs-6 py-2 shadow-sm">
                            <i class="bi bi-pencil-square me-2"></i> Edit Post
                        </a>
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog? This action is permanent.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-lg w-100 rounded-pill fs-6 py-2 mt-1">
                                <i class="bi bi-trash3 me-2"></i> Delete Post
                            </button>
                        </form>
                    </div>

                    <div class="small text-muted text-center mt-3">
                        Created: {{ $blog->created_at->format('M d, Y') }}<br>
                        Last Updated: {{ $blog->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
