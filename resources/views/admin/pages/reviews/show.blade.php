@extends('admin.layouts.master')

@section('title', 'View Review')

@section('content')
<div class="p-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">⭐ View Review</h4>
            <p class="text-muted mb-0">Review details</p>
        </div>
        <div>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">⬅ Back to Reviews</a>
        </div>
    </div>

    <div class="card shadow" style="max-width: 600px;">
        <div class="card-body">
            <h5 class="card-title fw-bold">{{ $review->name }}</h5>
            <h6 class="card-subtitle mb-3 text-muted">{{ $review->email ?? 'No email provided' }}</h6>
            
            <div class="mb-3">
                <strong>Rating:</strong> 
                @for($i = 0; $i < $review->rating; $i++)
                    <span class="text-warning fs-5">★</span>
                @endfor
                @for($i = $review->rating; $i < 5; $i++)
                    <span class="text-secondary fs-5">☆</span>
                @endfor
            </div>
            
            <div class="mb-3">
                <strong>Status:</strong> 
                @if($review->is_approved)
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-warning text-dark">Pending</span>
                @endif
            </div>

            <div class="mb-4">
                <strong>Comment:</strong>
                <p class="mt-2 p-3 bg-light rounded text-dark" style="border-left: 4px solid #f39c12;">
                    {{ $review->comment }}
                </p>
            </div>
            
            <div class="d-flex gap-2">
                <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-{{ $review->is_approved ? 'secondary' : 'success' }}">
                        {{ $review->is_approved ? 'Unapprove' : 'Approve Review' }}
                    </button>
                </form>
                
                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Are you sure you want to delete this review?')" class="btn btn-danger">Delete Review</button>
                </form>
            </div>
            
            <div class="mt-4 text-muted small">
                Submitted on: {{ $review->created_at->format('M d, Y h:i A') }}
            </div>
        </div>
    </div>
</div>
@endsection
