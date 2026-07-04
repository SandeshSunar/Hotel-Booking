@extends('admin.layouts.master')

@section('title','Add Gallery Image')
@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">➕ Add Gallery Image</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" required>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Upload</button>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
