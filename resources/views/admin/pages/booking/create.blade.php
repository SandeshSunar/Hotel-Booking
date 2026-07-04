@extends('admin.layouts.master')

@section('title', 'Add Booking')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">➕ Add Booking</h4>

    <form action="{{ route('admin.booking.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label>Room Type</label>
                <select name="room_type_id" class="form-select" required>
                    <option value="">Select Room Type</option>
                    @foreach($roomTypes as $roomType)
                        <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-4"><label>Guest Name</label><input type="text" name="guest_name" class="form-control" required></div>
            <div class="col-md-4"><label>Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="col-md-4"><label>Phone</label><input type="text" name="phone" class="form-control" required></div>
            <div class="col-md-4"><label>Check In</label><input type="date" name="check_in" class="form-control" required></div>
            <div class="col-md-4"><label>Check Out</label><input type="date" name="check_out" class="form-control" required></div>
            <div class="col-md-4"><label>Rooms</label><input type="number" name="rooms_count" class="form-control" value="1" min="1" required></div>
            <div class="col-md-4"><label>Adults</label><input type="number" name="adults" class="form-control" value="1" min="1" required></div>
            <div class="col-md-4"><label>Children</label><input type="number" name="children" class="form-control" value="0" min="0"></div>
            <div class="col-12"><label>Special Requests</label><textarea name="special_requests" class="form-control" rows="3"></textarea></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-success">Save Booking</button>
            <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
