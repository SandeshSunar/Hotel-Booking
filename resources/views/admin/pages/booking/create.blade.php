@extends('admin.layouts.master')

@section('title', 'Add Booking')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">➕ Add Booking</h4>

    <form action="{{ route('admin.booking.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Guest</label>
            <select name="user_id" class="form-select" required>
                <option value="">Select Guest</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Room</label>
            <select name="room_id" class="form-select" required>
                <option value="">Select Room</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Check In Date</label>
            <input type="date" name="check_in_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Check Out Date</label>
            <input type="date" name="check_out_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Booking</button>
        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
