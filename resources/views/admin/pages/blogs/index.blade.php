@extends('admin.layouts.master')

@section('title', 'Blogs List')

@section('content')
<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">📝 Blogs</h4>
            <p class="text-muted mb-0">Manage all blog posts on your website.</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-success shadow-sm">
            ➕ Create New Blog
        </a>
    </div>

 

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr>
                                <td class="ps-4">
                                    @if($blog->image)
                                        <img src="{{ Str::startsWith($blog->image, 'http') ? $blog->image : asset('storage/' . $blog->image) }}" alt="Blog Image" class="rounded object-fit-cover shadow-sm" width="80" height="50">
                                    @else
                                        <div class="bg-light rounded d-flex justify-content-center align-items-center text-muted" style="width: 80px; height: 50px; font-size: 0.8rem;">No Image</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $blog->title }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 200px;">{{ $blog->slug }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">{{ $blog->category }}</span>
                                </td>
                                <td>{{ $blog->date ?? $blog->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-sm btn-outline-info">View</a>
                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="fs-4 mb-2">📄</div>
                                    No blogs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($blogs->hasPages())
                <div class="card-footer bg-white border-top border-light p-3">
                    {{ $blogs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
