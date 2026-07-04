@extends('admin.layouts.master')

@section('title','Edit Gallery Image')
@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">✏️ Edit Gallery Image</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $gallery->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label>
            <div>
                <img src="{{ asset('storage/'.$gallery->image_path) }}" alt="{{ $gallery->title }}" width="150" class="rounded border">
            </div>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Replace Image (optional)</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
