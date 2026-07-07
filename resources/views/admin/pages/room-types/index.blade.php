@extends('admin.layouts.master')

@section('title', 'Room Types')

@section('content')
<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">🛏️ Room Types</h4>
            <p class="text-muted mb-0">Manage Single, Double, and Family room profiles independently.</p>
        </div>
        <a href="{{ route('admin.room-types.create') }}" class="btn btn-success">➕ Add Room Type</a>
    </div>


    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Room Type</th>
                        <th>Price / Night</th>
                        <th>Capacity</th>
                        <th>Rooms</th>
                        <th>Status</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roomTypes as $roomType)
                        <tr>
                            <td>{{ $roomType->id }}</td>
                            <td>
                                @if($roomType->primary_image)
                                    <img src="{{ asset('storage/' . $roomType->primary_image) }}" width="70" height="55" class="rounded object-fit-cover">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $roomType->name }}</strong>
                                <div class="small text-muted">{{ $roomType->category_label }} @if($roomType->room_number) · #{{ $roomType->room_number }} @endif</div>
                                <div class="small text-muted">{{ Str::limit($roomType->short_description ?? $roomType->description, 60) }}</div>
                            </td>
                            <td>
                                Rs. {{ number_format($roomType->display_price, 2) }}
                                @if($roomType->discount_price)
                                    <div class="small text-muted"><s>Rs. {{ number_format($roomType->price_per_night, 2) }}</s></div>
                                @endif
                            </td>
                            <td>{{ $roomType->capacity_label }}</td>
                            <td>{{ $roomType->available_rooms }} / {{ $roomType->total_rooms }}</td>
                            <td>
                                <span class="badge {{ $roomType->status === 'available' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($roomType->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $roomType->is_active ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ $roomType->is_active ? 'Enabled' : 'Disabled' }}
                                </span>
                            </td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.room-types.edit', $roomType) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.room-types.destroy', $roomType) }}" method="POST" onsubmit="return confirm('Delete this room type?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted">No room types found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
