@extends('admin.layouts.master')

@section('title', 'Create Blog')

@section('content')
<div class="p-4">
    <div class="mb-4">
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-secondary mb-2">&larr; Back to Blogs</a>
        <h4 class="fw-bold">Create New Blog</h4>
    </div>

    <div class="card shadow border-0 rounded-4 max-w-3xl mx-auto">
        <div class="card-body p-4">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <input type="text" name="category" class="form-control" value="{{ old('category') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Blog Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date</label>
                        <input type="text" name="date" class="form-control" value="{{ old('date', date('M d, Y')) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Read Time</label>
                        <input type="text" name="read_time" class="form-control" value="{{ old('read_time') }}" placeholder="e.g. 4 min read">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Excerpt <span class="text-danger">*</span></label>
                        <textarea name="excerpt" class="form-control" rows="3" required>{{ old('excerpt') }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Content (Paragraphs)</label>
                        <textarea name="content" class="form-control" rows="6" placeholder="Enter content paragraphs... each new line will be a new paragraph">{{ old('content') }}</textarea>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">Save Blog</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
