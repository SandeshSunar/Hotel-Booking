@extends('admin.layouts.master')

@section('title', 'Bookings')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">📅 Booking Management</h4>

    <!-- Add Booking Button -->
    <a href="{{ route('admin.booking.create') }}" class="btn btn-success mb-3">+ Add Booking</a>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bookings Table -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Room ID</th>
                        <th>Room Number</th>
                        <th>Guest Name</th>
                        <th>Room Type</th>
                        <th>Arrival Date</th>
                        <th>Leave Date</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Status Update</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <!-- Room ID -->
                            <td>{{ $booking->room->id }}</td>

                            <!-- Room Number -->
                            <td>{{ $booking->room->room_Number }}</td>

                            <!-- Guest Name -->
                            <td>{{ $booking->user->name ?? $booking->guest_name }}</td>

                            <!-- Room Type -->
                            <td>{{ ucfirst($booking->room->type) }}</td>

                            <!-- Arrival Date -->
                            <td>
                                {{ isset($booking->check_in)
                                    ? \Carbon\Carbon::parse($booking->check_in)->format('d M, Y')
                                    : '-' 
                                }}
                            </td>

                            <!-- Leave Date -->
                            <td>
                                {{ isset($booking->check_out)
                                    ? \Carbon\Carbon::parse($booking->check_out)->format('d M, Y')
                                    : '-'
                                }}
                            </td>

                            <!-- Price -->
                            <td>Rs. {{ number_format($booking->room->price ?? 0, 2) }}</td>

                            <!-- Image -->
                            <td>
                                @if($booking->room->image)
                                    <img src="{{ asset('storage/' . $booking->room->image) }}" width="80" height="60" class="rounded">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td>
                                @if($booking->status == 'confirmed')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($booking->status == 'cancelled')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            <!-- Status Update Buttons -->
                            <td>
                                @if($booking->status == 'pending')
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.booking.approve', $booking->id) }}" class="btn btn-success btn-sm">Approve</a>
                                        <a href="{{ route('admin.booking.reject', $booking->id) }}" class="btn btn-warning btn-sm">Reject</a>
                                    </div>
                                @else
                                    <span class="text-muted">No action</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td>
                                <a href="{{ route('admin.booking.edit', $booking->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">No bookings found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
