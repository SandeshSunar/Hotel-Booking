@extends('admin.layouts.master')

@section('title', 'Edit Room')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">✏️ Edit Room</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Room Number <span class="text-danger">*</span></label>
            <input type="text" name="room_number"
                class="form-control @error('room_number') is-invalid @enderror"
                value="{{ old('room_number', $room->room_number) }}" required>
            @error('room_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Room Type <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="">-- Select Room Type --</option>
                <option value="deluxe" {{ old('type', $room->type) == 'deluxe' ? 'selected' : '' }}>Deluxe Room</option>
                <option value="suite" {{ old('type', $room->type) == 'suite' ? 'selected' : '' }}>Suite Room</option>
                <option value="family" {{ old('type', $room->type) == 'family' ? 'selected' : '' }}>Family Room</option>
                <option value="single" {{ old('type', $room->type) == 'single' ? 'selected' : '' }}>Single Room</option>
                <option value="double" {{ old('type', $room->type) == 'double' ? 'selected' : '' }}>Double Room</option>
                <option value="presidential" {{ old('type', $room->type) == 'presidential' ? 'selected' : '' }}>Presidential Room</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Price (Rs) <span class="text-danger">*</span></label>
            <input type="number" name="price"
                class="form-control @error('price') is-invalid @enderror"
                value="{{ old('price', $room->price) }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                <option value="booked" {{ old('status', $room->status) == 'booked' ? 'selected' : '' }}>Booked</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Wifi</label>
            <select name="wifi" class="form-select">
                <option value="yes" {{ old('wifi', $room->wifi) == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ old('wifi', $room->wifi) == 'no' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Description <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                rows="5" required>{{ old('description', $room->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Image @if(!$room->image)<span class="text-danger">*</span>@endif</label><br>
            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}" width="100" class="rounded mb-2">
            @endif
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                {{ $room->image ? '' : 'required' }}>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update Room</button>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
