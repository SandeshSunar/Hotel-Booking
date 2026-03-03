@extends('admin.layouts.master')

@section('title', 'Edit Booking')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">✏️ Edit Booking</h4>

    <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Guest</label>
            <select name="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Room</label>
            <select name="room_id" class="form-select" required>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ $booking->room_id == $room->id ? 'selected' : '' }}>{{ $room->room_number }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Check In Date</label>
            <input type="date" name="check_in_date" class="form-control" value="{{ $booking->check_in_date }}" required>
        </div>

        <div class="mb-3">
            <label>Check Out Date</label>
            <input type="date" name="check_out_date" class="form-control" value="{{ $booking->check_out_date }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Booking</button>
        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
