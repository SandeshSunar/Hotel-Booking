@extends('admin.layouts.master')

@section('title', 'Rooms')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">🛏️ Room Management</h4>
    <p class="text-muted">List of all hotel rooms and availability.</p>

    <a href="{{ route('admin.rooms.create') }}" class="btn btn-success mb-3">➕ Add Room</a>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Room Number</th>
                        <th>Image</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Wifi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td>{{ $room->id }}</td>
                            <td>{{ $room->room_Number }}</td> <!-- match your DB column -->
                            <td>
                                @if($room->image)
                                    <img src="{{ asset('storage/' . $room->image) }}" width="80" height="80" class="rounded">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ ucfirst($room->type) }}</td>
                            <td>Rs. {{ number_format($room->price, 2) }}</td>
                            <td>
                                <span class="badge {{ $room->status == 'available' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </td>
                            <td style="max-width: 300px; white-space: normal; word-wrap: break-word; line-height: 1.6; font-size: 14px; padding: 8px;">
                                {{ $room->description ?? '-' }}
                            </td>                           
                            <td>{{ ucfirst($room->wifi) }}</td>
                            <td>
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No rooms found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
