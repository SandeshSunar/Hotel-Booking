@extends('admin.layouts.master')

@section('title', 'Reviews')

@section('content')
<style>
/* Custom Review Management Styles */
.reviews-wrapper {
    background-color: #f4f6f9;
    min-height: calc(100vh - 60px); 
}
.reviews-card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.reviews-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.08) !important;
}
.reviews-card .card-body {
    padding: 1.25rem;
    position: relative;
    z-index: 2;
}
.reviews-icon {
    font-size: 3rem;
    position: absolute;
    right: 15px;
    bottom: 10px;
    opacity: 0.15;
    z-index: 1;
    transition: transform 0.3s ease;
}
.reviews-card:hover .reviews-icon {
    transform: scale(1.1) rotate(5deg);
}

.bg-grad-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-grad-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.bg-grad-warning { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }

.modern-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.03);
    overflow: hidden;
}
.modern-card .card-header {
    background-color: #fff;
    border-bottom: 1px solid rgba(230, 230, 230, 0.7);
    padding: 18px 25px;
}
.status-badge {
    padding: 0.5em 1em;
    border-radius: 50rem;
    font-weight: 500;
    font-size: 0.8rem;
    letter-spacing: 0.3px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.star-rating .text-warning {
    color: #ffc107 !important;
}
</style>

<div class="p-4 reviews-wrapper">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-star-half text-primary me-2"></i>Review Management
            </h4>
            <p class="text-muted small mb-0 mt-1">Manage guest reviews, approvals, and monitor feedback.</p>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- STATISTICS CARDS -->
    <div class="row g-4 mb-4">
        <div class="col-md-4 col-sm-12 text-white">
            <div class="card reviews-card bg-grad-primary shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Total Reviews</h6>
                    <h2 class="mb-0 fw-bold">{{ \App\Models\Review::count() }}</h2>
                    <i class="bi bi-chat-quote reviews-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 text-white">
            <div class="card reviews-card bg-grad-success shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Approved</h6>
                    <h2 class="mb-0 fw-bold">{{ \App\Models\Review::where('is_approved', true)->count() }}</h2>
                    <i class="bi bi-check-circle reviews-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 text-white">
            <div class="card reviews-card bg-grad-warning shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Pending Approval</h6>
                    <h2 class="mb-0 fw-bold">{{ \App\Models\Review::where('is_approved', false)->count() }}</h2>
                    <i class="bi bi-clock-history reviews-icon"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- SEARCH & CONTROLS -->
    <div class="card modern-card shadow-sm mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Search reviews..." style="max-width: 350px;">
                    <button class="btn btn-primary px-4" type="submit">Search</button>
                    @if(request('search'))
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary px-3">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- REVIEWS TABLE -->
    <div class="card modern-card shadow-sm">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-list-stars text-primary me-2"></i>Reviews List
            </h5>
            <span class="badge bg-light text-secondary border">Feedback</span>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">ID #</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Guest Info</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Rating</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; width: 30%;">Comment</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Status</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Date</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark fs-6">#{{ $review->id }}</span>
                            </td>
                            
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ $review->name }}</span>
                                    <span class="text-muted small">{{ $review->email ?? 'N/A' }}</span>
                                </div>
                            </td>
                            
                            <td>
                                <div class="star-rating fs-6">
                                    @for($i = 0; $i < $review->rating; $i++)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                                    @for($i = $review->rating; $i < 5; $i++)
                                        <i class="bi bi-star text-secondary opacity-50"></i>
                                    @endfor
                                </div>
                            </td>
                            
                            <td class="text-secondary small">
                                <div style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{ $review->comment }}">
                                    {!! nl2br(e($review->comment)) !!}
                                </div>
                            </td>

                            <td>
                                @if($review->is_approved)
                                    <span class="badge status-badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">
                                        <i class="bi bi-check-circle-fill"></i> Approved
                                    </span>
                                @else
                                    <span class="badge status-badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2" style="color: #d97706 !important;">
                                        <i class="bi bi-clock-fill"></i> Pending
                                    </span>
                                @endif
                            </td>
                            
                            <td>
                                <span class="text-secondary small">{{ $review->created_at->format('M d, Y') }}<br>{{ $review->created_at->format('h:i A') }}</span>
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                        @csrf
                                        @if($review->is_approved)
                                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Unapprove">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        @endif
                                    </form>
                                    
                                    <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-info text-white" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-chat-left-text fs-1 d-block mb-3 opacity-40"></i>
                                <h5>No Reviews Found</h5>
                                <p class="small">There are currently no reviews matching your criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reviews->hasPages())
        <div class="card-footer bg-white border-top py-3">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
