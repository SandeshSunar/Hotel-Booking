{{-- @extends('admin.layouts.master')

@section('title', 'Room #' . $room->room_number . ' Details')

@section('content')
<style>
    .show-wrapper {
        background-color: #f4f6f9;
        min-height: calc(100vh - 60px);
    }
    .hover-shadow {
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .gallery-main {
        height: 380px;
        object-fit: cover;
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: opacity 0.3s ease;
    }
    .gallery-thumb {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        border-radius: 8px;
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }
    .gallery-thumb:hover {
        border-color: #667eea;
        transform: translateY(-2px);
    }
    .gallery-thumb.active {
        border-color: #667eea;
        box-shadow: 0 0 8px rgba(102, 126, 234, 0.5);
    }
    .info-label {
        font-weight: 600;
        color: #64748b;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.1rem;
    }
    .feature-badge {
        background-color: #f1f5f9;
        color: #334155;
        border-radius: 8px;
        padding: 8px 12px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .history-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
    }
    .history-table th {
        background-color: #f8fafc;
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
    }
    .history-table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    .status-badge {
        padding: 0.5em 1em;
        border-radius: 50rem;
        font-weight: 500;
        font-size: 0.8rem;
    }
</style>

<div class="p-4 show-wrapper">
    <!-- Breadcrumb & Title Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="text-muted small mb-1">
                <a href="{{ route('admin.dashboard.index') }}" class="text-decoration-none text-muted">Dashboard</a> 
                <span class="mx-1">/</span> 
                <a href="{{ route('admin.rooms.index') }}" class="text-decoration-none text-muted">Rooms</a> 
                <span class="mx-1">/</span> 
                <span class="text-primary font-medium">Room #{{ $room->room_number }}</span>
            </div>
            <h3 class="fw-bold mb-0 text-dark">
                🛏️ Room #{{ $room->room_number }} Details
            </h3>
        </div>
        <div>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary rounded-pill px-3 me-2">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
            <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
                <i class="bi bi-pencil me-1"></i> Edit Room
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Side: Images & Description -->
        <div class="col-lg-8">
            <!-- Image Gallery Panel -->
            <div class="card border-0 rounded-4 shadow-sm mb-4">
                <div class="card-body p-4">
                    @php
                        $coverImage = $room->image ?: ($room->images->first()?->image_path);
                    @endphp
                    
                    @if($coverImage)
                        <img id="mainImage" src="{{ asset('storage/' . $coverImage) }}" class="gallery-main mb-3" alt="Room Cover">
                        
                        @if($room->images->count() > 0)
                            <div class="d-flex flex-wrap gap-2 overflow-x-auto pb-2">
                                @foreach($room->images as $img)
                                    <img src="{{ asset('storage/' . $img->image_path) }}" 
                                         class="gallery-thumb {{ $coverImage === $img->image_path ? 'active' : '' }}" 
                                         alt="Room Thumbnail"
                                         onclick="changeCover('{{ asset('storage/' . $img->image_path) }}', this)">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="bg-light rounded-4 d-flex flex-column align-items-center justify-content-center py-5 border border-dashed text-muted">
                            <i class="bi bi-image fs-1 mb-2"></i>
                            <span>No images uploaded for this room</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Room Description Panel -->
            <div class="card border-0 rounded-4 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-dark">
                        <i class="bi bi-card-text text-primary me-2"></i>Description
                    </h5>
                    <p class="text-secondary mb-0" style="line-height: 1.7; font-size: 1.05rem; white-space: pre-line;">
                        {{ $room->description ?: 'No description provided for this room.' }}
                    </p>
                </div>
            </div>

            <!-- Booking History Panel -->
            <div class="card history-card rounded-4 shadow-sm">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-calendar-range text-primary me-2"></i>Booking History
                    </h5>
                    <span class="badge bg-light text-secondary border">{{ $room->bookings->count() }} Booking(s)</span>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table history-table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Guest Info</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($room->bookings as $booking)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $booking->guest_name }}</div>
                                        <div class="text-muted small"><i class="bi bi-envelope me-1"></i>{{ $booking->email }}</div>
                                        <div class="text-muted small"><i class="bi bi-telephone me-1"></i>{{ $booking->phone }}</div>
                                    </td>
                                    <td>
                                        <div class="text-dark fw-medium">
                                            @if($booking->check_in instanceof \Carbon\Carbon)
                                                {{ $booking->check_in->format('M d, Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark fw-medium">
                                            @if($booking->check_out instanceof \Carbon\Carbon)
                                                {{ $booking->check_out->format('M d, Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        Rs. {{ number_format($booking->total_price, 2) }}
                                    </td>
                                    <td>
                                        @if(strtolower($booking->status) == 'completed')
                                            <span class="badge status-badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">{{ ucfirst($booking->status) }}</span>
                                        @elseif(strtolower($booking->status) == 'cancelled')
                                            <span class="badge status-badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">{{ ucfirst($booking->status) }}</span>
                                        @elseif(strtolower($booking->status) == 'confirmed')
                                            <span class="badge status-badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ ucfirst($booking->status) }}</span>
                                        @else
                                            <span class="badge status-badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('admin.booking.edit', $booking->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            Edit/Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-calendar-x fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                        No bookings found for this room.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Side: Room Quick Stats -->
        <div class="col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm mb-4 sticky-top" style="top: 24px; z-index: 10;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-dark-emphasis">
                        <i class="bi bi-info-circle text-primary me-2"></i>Quick Overview
                    </h5>

                    <!-- Status Display -->
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <div class="small text-muted text-uppercase fw-semibold mb-2">Current Availability</div>
                        @if($room->status == 'available')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-4 py-2 fs-6 rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i> Available
                            </span>
                        @elseif($room->status == 'booked')
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-4 py-2 fs-6 rounded-pill">
                                <i class="bi bi-clock-history me-1"></i> Booked
                            </span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-4 py-2 fs-6 rounded-pill">
                                <i class="bi bi-x-circle-fill me-1"></i> {{ ucfirst($room->status) }}
                            </span>
                        @endif
                    </div>

                    <!-- Details Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 col-12 w-100">
                                <div class="info-label"><i class="bi bi-tag me-1"></i> Room Type</div>
                                <div class="info-value text-capitalize">{{ $room->type }}</div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 col-12 w-100">
                                <div class="info-label"><i class="bi bi-cash-coin me-1"></i> Price</div>
                                <div class="info-value">Rs. {{ number_format($room->price, 0) }}<span class="fs-6 fw-normal text-muted">/N</span></div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 col-12 w-100">
                                <div class="info-label"><i class="bi bi-wifi me-1"></i> Wi-Fi</div>
                                <div class="info-value text-capitalize">{{ $room->wifi }}</div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 col-12 w-100">
                                <div class="info-label"><i class="bi bi-hash me-1"></i> Room ID</div>
                                <div class="info-value">#{{ $room->id }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Amenities list -->
                    <h6 class="fw-bold mb-3"><i class="bi bi-grid-fill text-primary me-2"></i>Features</h6>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="feature-badge">
                            <i class="bi bi-wifi text-primary"></i> Wifi: {{ ucfirst($room->wifi) }}
                        </span>
                        <span class="feature-badge">
                            <i class="bi bi-door-closed text-primary"></i> Room No. {{ $room->room_number }}
                        </span>
                        <span class="feature-badge">
                            <i class="bi bi-clipboard2-data text-primary"></i> Status: {{ ucfirst($room->status) }}
                        </span>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- Actions -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-primary btn-lg rounded-pill fs-6 py-2 shadow-sm">
                            <i class="bi bi-pencil-square me-2"></i> Edit Details
                        </a>
                        <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room? This action is permanent.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-lg w-100 rounded-pill fs-6 py-2 mt-1">
                                <i class="bi bi-trash3 me-2"></i> Delete Room
                            </button>
                        </form>
                    </div>

                    <div class="small text-muted text-center mt-3">
                        Created: {{ $room->created_at->format('M d, Y') }}<br>
                        Last Updated: {{ $room->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeCover(src, thumbElement) {
        // Change image source
        const mainImage = document.getElementById('mainImage');
        mainImage.style.opacity = '0.3';
        
        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.opacity = '1';
        }, 150);

        // Remove active class from all thumbnails
        document.querySelectorAll('.gallery-thumb').forEach(thumb => {
            thumb.classList.remove('active');
        });

        // Add active class to clicked thumbnail
        thumbElement.classList.add('active');
    }
</script>
@endsection --}}
