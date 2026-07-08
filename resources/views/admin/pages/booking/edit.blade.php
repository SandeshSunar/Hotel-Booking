@extends('admin.layouts.master')

@section('title', 'Edit Booking')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">✏️ Edit Booking</h4>

    <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label>Room Type</label>
                <select name="room_type_id" class="form-select" required>
                    @foreach($roomTypes as $roomType)
                        <option value="{{ $roomType->id }}" {{ $booking->room_type_id == $roomType->id ? 'selected' : '' }}>{{ $roomType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-4"><label>Guest Name</label><input type="text" name="guest_name" class="form-control" value="{{ $booking->guest_name }}" required></div>
            <div class="col-md-4"><label>Email</label><input type="email" name="email" class="form-control" value="{{ $booking->email }}" required></div>
            <div class="col-md-4"><label>Phone</label><input type="text" name="phone" class="form-control" value="{{ $booking->phone }}" required></div>
            <div class="col-md-4"><label>Check In</label><input type="date" name="check_in" class="form-control" value="{{ $booking->check_in->format('Y-m-d') }}" required></div>
            <div class="col-md-4"><label>Check Out</label><input type="date" name="check_out" class="form-control" value="{{ $booking->check_out->format('Y-m-d') }}" required></div>
            <div class="col-md-4"><label>Rooms</label><input type="number" name="rooms_count" class="form-control" value="{{ $booking->rooms_count }}" min="1" required></div>
            <div class="col-md-4"><label>Adults</label><input type="number" name="adults" class="form-control" value="{{ $booking->adults }}" min="1" required></div>
            <div class="col-md-4"><label>Children</label><input type="number" name="children" class="form-control" value="{{ $booking->children }}" min="0"></div>
            <div class="col-12"><label>Special Requests</label><textarea name="special_requests" class="form-control" rows="3">{{ $booking->special_requests }}</textarea></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Booking</button>
            
            @if($booking->status !== 'confirmed')
                <a href="{{ route('admin.booking.approve', $booking->id) }}" class="btn btn-success" onclick="return confirm('Quickly confirm this booking?');">Mark Confirmed</a>
            @endif
            
            @if($booking->status !== 'cancelled')
                <a href="{{ route('admin.booking.reject', $booking->id) }}" class="btn btn-danger" onclick="return confirm('Cancel this booking?');">Mark Cancelled</a>
            @endif
            
            <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
