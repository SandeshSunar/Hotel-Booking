@extends('admin.layouts.master')

@section('title', 'View Room Type')

@section('content')
<style>
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
</style>
<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Room Details: {{ $roomType->name }}</h4>
            <p class="text-muted mb-0">Complete information about this room type.</p>
        </div>
        <div>
            <a href="{{ route('admin.room-types.edit', $roomType) }}" class="btn btn-primary me-2">Edit Room</a>
            <a href="{{ route('admin.room-types.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Details -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">General Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Room Name</div>
                        <div class="col-sm-8 fw-semibold">{{ $roomType->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Category</div>
                        <div class="col-sm-8">{{ $roomType->category_label }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Room Number</div>
                        <div class="col-sm-8">{{ $roomType->room_number ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Bed Type</div>
                        <div class="col-sm-8">{{ $roomType->bed_type ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Room Size</div>
                        <div class="col-sm-8">{{ $roomType->room_size ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Short Description</div>
                        <div class="col-sm-8">{{ $roomType->short_description ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Full Description</div>
                        <div class="col-sm-8">{{ $roomType->description }}</div>
                    </div>
                </div>
            </div>

            <!-- Facilities -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Facilities</h5>
                </div>
                <div class="card-body">
                    @if($roomType->facilities->isNotEmpty())
                        <ul class="list-unstyled d-flex flex-wrap gap-2 mb-0">
                            @foreach($roomType->facilities as $facility)
                                <li>
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        <i class="bi bi-check2-circle text-success me-1"></i> {{ $facility->name }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">No facilities listed for this room.</p>
                    @endif
                </div>
            </div>

            <!-- Images gallery -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Room Images</h5>
                </div>
                <div class="card-body">
                    @php
                        $coverImage = $roomType->primary_image ?: ($roomType->images->first()?->image_path);
                    @endphp
                    
                    @if($coverImage)
                        <img id="mainImage" src="{{ asset('storage/' . $coverImage) }}" class="gallery-main mb-3" alt="Room Cover">
                        
                        @if($roomType->images->count() > 0)
                            <div class="d-flex flex-wrap gap-2 overflow-x-auto pb-2">
                                @foreach($roomType->images as $img)
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
                            <span>No images uploaded for this room type</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Pricing & Capacity</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted small">Price Per Night</div>
                        <div class="fw-bold fs-5">Rs. {{ number_format($roomType->price_per_night, 2) }}</div>
                    </div>
                    @if($roomType->discount_price)
                    <div class="mb-3">
                        <div class="text-muted small">Discounted Price</div>
                        <div class="fw-bold fs-5 text-success">Rs. {{ number_format($roomType->discount_price, 2) }}</div>
                    </div>
                    @endif
                    <hr>
                    <div class="row text-center my-3">
                        <div class="col-6 border-end">
                            <div class="text-muted small">Adults</div>
                            <div class="fw-bold fs-5"><i class="bi bi-person"></i> {{ $roomType->capacity_adults }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Children</div>
                            <div class="fw-bold fs-5"><i class="bi bi-person fs-6"></i> {{ $roomType->capacity_children }}</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center mt-3">
                        <div class="col-6 border-end">
                            <div class="text-muted small">Total Rooms</div>
                            <div class="fw-bold fs-5">{{ $roomType->total_rooms }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Available</div>
                            <div class="fw-bold fs-5 text-primary">{{ $roomType->available_rooms }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Web Visibility</div>
                        <span class="badge {{ $roomType->is_active ? 'bg-primary' : 'bg-secondary' }} px-3 py-2">
                            {{ $roomType->is_active ? 'Enabled / Active' : 'Disabled / Hidden' }}
                        </span>
                    </div>
                    <div>
                        <div class="text-muted small mb-1">Current Manual Status</div>
                        <span class="badge {{ $roomType->status === 'available' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                            {{ ucfirst($roomType->status) }}
                        </span>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <div class="text-muted small mb-1">Real-time Booked Check</div>
                        @if($roomType->is_currently_booked)
                            <span class="badge bg-danger px-3 py-2">Currently Booked</span>
                            <div class="small text-muted mt-1">This room is booked for today or manually set to unavailable.</div>
                        @else
                            <span class="badge bg-success px-3 py-2">Not Booked</span>
                        @endif
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
@endsection
