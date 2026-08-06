@extends('admin.layouts.master')

@section('title', 'Reviews')

@section('content')
<div class="p-4">
    <div class="mb-4">
        <div>
            <h4 class="fw-bold mb-1">⭐ Review Management</h4>
            <p class="text-muted mb-3">List of all guest reviews.</p>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ $review->name }}</td>
                            <td>{{ $review->email ?? 'N/A' }}</td>
                            <td>
                                @for($i = 0; $i < $review->rating; $i++)
                                    <span class="text-warning">★</span>
                                @endfor
                                @for($i = $review->rating; $i < 5; $i++)
                                    <span class="text-secondary">☆</span>
                                @endfor
                            </td>
                            <td>
                                @if($review->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-info">View</a>
                                
                                <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-{{ $review->is_approved ? 'secondary' : 'success' }}">
                                        {{ $review->is_approved ? 'Unapprove' : 'Approve' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure you want to delete this review?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">No reviews found</td></tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-3">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
