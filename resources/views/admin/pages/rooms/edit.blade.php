@extends('admin.layouts.master')

@section('title', 'Edit Room')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">✏️ Edit Room</h4>

    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Room Number -->
        <div class="mb-3">
            <label>Room Number</label>
            <input type="text"
                   name="room_number"
                   class="form-control"
                   value="{{ old('room_number', $room->room_number) }}"
                   required>
        </div>

        <!-- Room Type -->
        <div class="mb-3">
            <label for="type" class="form-label">Room Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">-- Select Room Type --</option>
                <option value="deluxe" {{ old('type', $room->type) == 'deluxe' ? 'selected' : '' }}>Deluxe Room</option>
                <option value="suite" {{ old('type', $room->type) == 'suite' ? 'selected' : '' }}>Suite Room</option>
                <option value="family" {{ old('type', $room->type) == 'family' ? 'selected' : '' }}>Family Room</option>
                <option value="single" {{ old('type', $room->type) == 'single' ? 'selected' : '' }}>Single Room</option>
                <option value="double" {{ old('type', $room->type) == 'double' ? 'selected' : '' }}>Double Room</option>
                <option value="presidential" {{ old('type', $room->type) == 'presidential' ? 'selected' : '' }}>Presidential Room</option>
            </select>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label>Price (Rs)</label>
            <input type="number"
                   name="price"
                   class="form-control"
                   value="{{ old('price', $room->price) }}"
                   required>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                <option value="booked" {{ old('status', $room->status) == 'booked' ? 'selected' : '' }}>Booked</option>
            </select>
        </div>

        <!-- Wifi -->
        <div class="mb-3">
            <label>Wifi</label>
            <select name="wifi" class="form-select">
                <option value="yes" {{ old('wifi', $room->wifi) == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ old('wifi', $room->wifi) == 'no' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $room->description) }}</textarea>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label>Image</label><br>
            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}" width="100" class="rounded mb-2">
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Room</button>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection