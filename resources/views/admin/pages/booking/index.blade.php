@extends('admin.layouts.master')

@section('title', 'Bookings')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">📅 Booking Management</h4>
    <a href="{{ route('admin.booking.create') }}" class="btn btn-success mb-3">+ Add Booking</a>

  
    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Guest</th>
                        <th>Room Type</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Guests</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>
                                <strong>{{ $booking->guest_name }}</strong>
                                <div class="small text-muted">{{ $booking->email }} · {{ $booking->phone }}</div>
                            </td>
                            <td>{{ $booking->roomType->name ?? 'N/A' }}</td>
                            <td>{{ $booking->check_in->format('d M, Y') }}</td>
                            <td>{{ $booking->check_out->format('d M, Y') }}</td>
                            <td>{{ $booking->adults }}A / {{ $booking->children }}C / {{ $booking->rooms_count }}R</td>
                            <td>Rs. {{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                @if($booking->status === 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($booking->status === 'completed')
                                    <span class="badge bg-info text-dark">Completed</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @if($booking->status === 'pending')
                                        <a href="{{ route('admin.booking.approve', $booking->id) }}" class="btn btn-success btn-sm">Confirm</a>
                                        <a href="{{ route('admin.booking.reject', $booking->id) }}" class="btn btn-warning btn-sm">Cancel</a>
                                    @endif
                                    @if($booking->status === 'confirmed')
                                        <a href="{{ route('admin.booking.complete', $booking->id) }}" class="btn btn-info btn-sm text-white">Complete</a>
                                    @endif
                                    <a href="{{ route('admin.booking.edit', $booking->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted">No bookings found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
