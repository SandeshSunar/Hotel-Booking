@extends('admin.layouts.master')

@section('title','Gallery')
@section('content')
<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">🖼️ Gallery</h4>
        <a href="{{ route('admin.gallery.create') }}" class="btn  btn-success mb-3~ ">➕ Add New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleries as $key => $gallery)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $gallery->title }}</td>
                    <td><img src="{{ asset('storage/'.$gallery->image_path) }}" alt="{{ $gallery->title }}" width="100"></td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-sm btn-primary"> Edit</a>
                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No images found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
