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
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Upload</button>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
