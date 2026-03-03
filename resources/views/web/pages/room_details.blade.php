@extends('web.layouts.master')

@section('title', 'Room Details')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center fw-bold">{{ $room->type }}</h1>

    <div class="row g-4">
        <!-- Left: Room Image + Details -->
        <div class="col-12 col-md-6">
            <div class="p-3 border rounded shadow-sm h-100">
                <img src="{{ asset('storage/' . $room->image) }}" class="img-fluid rounded mb-3" alt="Room Image">
                
                <h3 class="text-primary">Room Type: {{ $room->type }}</h3>
                <p class="text-muted">{{ $room->description }}</p>
                <p><strong>Price:</strong> ${{ $room->price }}</p>
                <p><strong>Status:</strong> {{ $room->status }}</p>
                <p><strong>Wifi:</strong> {{ $room->wifi ? 'Available' : 'Not Available' }}</p>
            </div>
        </div>

        <!-- Right: Booking Form -->
        <div class="col-12 col-md-6">
            <div class="p-3 border rounded shadow-sm h-100">
                <h4 class="mb-3">Book This Room</h4>

                <!-- Validation errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Success message -->
                @if(session('success'))
                    <div class="alert alert-success text-center" id="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Booking Form -->
                <form action="{{ route('booking.submit') }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                    <div class="mb-3">
                        <label for="guest_name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="guest_name" name="guest_name" placeholder="Enter your full name" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="10-digit number" required>
                    </div>

                    <div class="mb-3">
                        <label for="check_in" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="check_in" name="check_in" required>
                    </div>

                    <div class="mb-3">
                        <label for="check_out" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="check_out" name="check_out" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Book Room</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS validation for name and phone -->
<script>
function validateForm() {
    const name = document.getElementById('guest_name').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const checkIn = document.getElementById('check_in').value;
    const checkOut = document.getElementById('check_out').value;

    // Name: only letters and spaces
    const namePattern = /^[A-Za-z\s]+$/;
    if (!namePattern.test(name)) {
        alert('Name must contain only letters.');
        return false;
    }

    // Phone: exactly 10 digits
    const phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        alert('Phone number must be exactly 10 digits.');
        return false;
    }

    // Date check: check-in must be before check-out
    if (new Date(checkIn) >= new Date(checkOut)) {
        alert('End date must be after start date.');
        return false;
    }

    return true;
}
</script>
@endsection
