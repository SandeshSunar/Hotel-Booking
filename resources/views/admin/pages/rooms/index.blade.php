@extends('admin.layouts.master')

@section('title', 'Rooms')

@section('content')
<style>
/* Custom Room Management Styles */
.rooms-wrapper {
    background-color: #f4f6f9;
    min-height: calc(100vh - 60px); 
}
.rooms-card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.rooms-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.08) !important;
}
.rooms-card .card-body {
    padding: 1.25rem;
    position: relative;
    z-index: 2;
}
.rooms-icon {
    font-size: 3rem;
    position: absolute;
    right: 15px;
    bottom: 10px;
    opacity: 0.15;
    z-index: 1;
    transition: transform 0.3s ease;
}
.rooms-card:hover .rooms-icon {
    transform: scale(1.1) rotate(5deg);
}

.bg-grad-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-grad-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.bg-grad-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.bg-grad-danger { background: linear-gradient(135deg, #ff0844 0%, #ffb199 100%); }

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
.table-wrapper {
    padding: 0;
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
.wifi-badge {
    padding: 0.3em 0.8em;
    border-radius: 4px;
    font-weight: 600;
    font-size: 0.75rem;
    background-color: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}
.wifi-yes {
    background-color: #ecfdf5;
    color: #047857;
    border-color: #a7f3d0;
}
.wifi-no {
    background-color: #fef2f2;
    color: #b91c1c;
    border-color: #fca5a5;
}
.room-img-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.room-img-hover:hover {
    transform: scale(1.15);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    z-index: 10;
}
.action-btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.2s ease;
}
.action-btn:hover {
    transform: scale(1.1);
}
</style>

<div class="p-4 rooms-wrapper">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-door-closed text-primary me-2"></i>Room Management
            </h4>
            <p class="text-muted small mb-0 mt-1">Efficiently monitor, update, and manage your hotel rooms.</p>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-success rounded-pill px-4 py-2 font-medium shadow-sm hover-shadow d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle-fill"></i> Add New Room
        </a>
    </div>

    <!-- ================= STATISTICS CARDS ================= -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6 col-sm-12 text-white">
            <div class="card rooms-card bg-grad-primary shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Total Rooms</h6>
                    <h2 class="mb-0 fw-bold">{{ $rooms->count() }}</h2>
                    <i class="bi bi-building rooms-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12 text-white">
            <div class="card rooms-card bg-grad-success shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Available Rooms</h6>
                    <h2 class="mb-0 fw-bold">{{ $rooms->where('status', 'available')->count() }}</h2>
                    <i class="bi bi-shield-check rooms-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12 text-white">
            <div class="card rooms-card bg-grad-info shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Booked Rooms</h6>
                    <h2 class="mb-0 fw-bold">{{ $rooms->where('status', 'booked')->count() }} </h2>
                    <i class="bi bi-calendar2-check rooms-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12 text-white">
            <div class="card rooms-card bg-grad-danger shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Maintenance Rooms</h6>
                    <h2 class="mb-0 fw-bold">{{ $rooms->where('status', 'unavailable')->count() }}</h2>
                    <i class="bi bi-tools rooms-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= ROOMS TABLE ================= -->
    <div class="card modern-card shadow-sm">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-list-stars text-primary me-2"></i>Rooms Catalog
            </h5>
            <span class="badge bg-light text-secondary border">Active List</span>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Room #</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Preview</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Room Type</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Price Per Night</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Wifi</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Status</th>
                        <th class="py-3" style="max-width: 280px; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Description</th>
                        <th class="py-3" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <!-- Room Number -->
                            <td class="ps-4">
                                <span class="fw-bold text-dark fs-5">#{{ $room->room_number }}</span>
                            </td>
                            
                            <!-- Image Cover -->
                            <td>
                                @php
                                    $coverImage = $room->image ?: ($room->images->first()?->image_path);
                                @endphp
                                @if($coverImage)
                                    <img src="{{ asset('storage/' . $coverImage) }}" 
                                         width="65" height="65" 
                                         class="rounded-3 object-fit-cover shadow-sm room-img-hover border">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center border" style="width: 65px; height: 65px;">
                                        <i class="bi bi-image text-muted fs-4"></i>
                                    </div>
                                @endif
                            </td>
                            
                            <!-- Room Type -->
                            <td>
                                <span class="fw-semibold text-dark text-capitalize fs-6">{{ $room->type }}</span>
                            </td>
                            
                            <!-- Price -->
                            <td>
                                <span class="fw-bold text-dark fs-6">Rs. {{ number_format($room->price, 2) }}</span>
                            </td>
                            
                            <!-- Wifi -->
                            <td>
                                @if(strtolower($room->wifi) == 'yes')
                                    <span class="wifi-badge wifi-yes"><i class="bi bi-wifi me-1"></i>Yes</span>
                                @else
                                    <span class="wifi-badge wifi-no"><i class="bi bi-wifi-off me-1"></i>No</span>
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td>
                                @if($room->status == 'available')
                                    <span class="badge status-badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">
                                        <i class="bi bi-check-circle-fill"></i> Available
                                    </span>
                                @elseif($room->status == 'booked')
                                    <span class="badge status-badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2">
                                        <i class="bi bi-clock-history"></i> Booked
                                    </span>
                                @else
                                    <span class="badge status-badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2">
                                        <i class="bi bi-exclamation-triangle-fill"></i> {{ ucfirst($room->status) }}
                                    </span>
                                @endif
                            </td>

                            <!-- Description Snippet -->
                            <td class="text-secondary small" style="max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {!! nl2br(e($room->description)) ?? '-' !!}
                            </td>

                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-sm btn-info text-white">View</a>
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Delete this room?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-40"></i>
                                <h5>No Rooms Found</h5>
                                <p class="small">Add a room using the green button in the top right.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
