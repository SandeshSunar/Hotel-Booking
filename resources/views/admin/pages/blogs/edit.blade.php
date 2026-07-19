@extends('admin.layouts.master')

@section('title', 'Edit Blog')

@section('content')
<div class="p-4">
    <div class="mb-4">
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-secondary mb-2">&larr; Back to Blogs</a>
        <h4 class="fw-bold">Edit Blog: {{ $blog->title }}</h4>
    </div>

    <div class="card shadow border-0 rounded-4 max-w-3xl mx-auto">
        <div class="card-body p-4">
            <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <input type="text" name="category" class="form-control" value="{{ old('category', $blog->category) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Blog Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if($blog->image)
                            <div class="mt-2">
                                <img src="{{ Str::startsWith($blog->image, 'http') ? $blog->image : asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-thumbnail" style="height: 60px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date</label>
                        <input type="text" name="date" class="form-control" value="{{ old('date', $blog->date) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Read Time</label>
                        <input type="text" name="read_time" class="form-control" value="{{ old('read_time', $blog->read_time) }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Excerpt <span class="text-danger">*</span></label>
                        <textarea name="excerpt" class="form-control" rows="3" required>{{ old('excerpt', $blog->excerpt) }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Content (Paragraphs)</label>
                        <textarea name="content" class="form-control" rows="6">{{ old('content', $blogContent) }}</textarea>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">Update Blog</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
