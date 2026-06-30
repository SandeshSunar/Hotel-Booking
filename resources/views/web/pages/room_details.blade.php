@extends('web.layouts.master')

@section('title', 'Room Details')

@section('content')
<section class="room-details-hero">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <span class="room-details-badge"><i class="bi bi-stars"></i> Room Details</span>
                <h1 class="room-details-title">{{ $room->type }}</h1>
                <p class="room-details-subtitle">
                    Carefully designed for comfort, elegance, and an unforgettable stay experience.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="room-details-main py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-7">
                <article class="room-details-card h-100">
                    <div class="room-details-image-wrap">
                        <img src="{{ asset('storage/' . $room->image) }}" class="room-details-image" alt="Room Image">
                        <span class="room-details-tag">Guest Favorite</span>
                    </div>
                    <div class="room-details-content">
                        <h3 class="room-details-heading">{{ $room->type }}</h3>
                        <p class="room-details-text">{{ $room->description }}</p>
                        <div class="room-meta-grid">
                            <div class="room-meta-item">
                                <span>Price</span>
                                <strong>${{ $room->price }} / night</strong>
                            </div>
                            <div class="room-meta-item">
                                <span>Status</span>
                                <strong>{{ $room->status }}</strong>
                            </div>
                            <div class="room-meta-item">
                                <span>WiFi</span>
                                <strong>{{ $room->wifi ? 'High-Speed Available' : 'Not Available' }}</strong>
                            </div>
                            <div class="room-meta-item">
                                <span>Service</span>
                                <strong>24/7 Front Desk</strong>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-12 col-lg-5">
                <div class="room-booking-card h-100">
                    <h4 class="room-booking-title">Book This Room</h4>
                    <p class="room-booking-subtitle">Secure your stay in just a few steps.</p>

                    @if ($errors->any())
                    <div class="alert alert-danger room-booking-alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success text-center room-booking-alert" id="success-message">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('booking.submit') }}" method="POST" onsubmit="return validateForm()" class="room-booking-form">
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

                        <button type="submit" class="btn room-booking-btn w-100">Book Room</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="room-popular-features py-5">
    <div class="container">
        <div class="text-center mb-4">
            <span class="room-feature-tag">Popular Features</span>
            <h2 class="room-feature-title">Why guests love this room</h2>
        </div>
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="room-feature-card">
                    <i class="bi bi-wifi"></i>
                    <h6>Free WiFi</h6>
                    <p>{{ $room->wifi ? 'Included' : 'Optional' }}</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="room-feature-card">
                    <i class="bi bi-shield-check"></i>
                    <h6>Safe & Secure</h6>
                    <p>24/7 support</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="room-feature-card">
                    <i class="bi bi-cup-hot"></i>
                    <h6>Complimentary</h6>
                    <p>Welcome refreshment</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="room-feature-card">
                    <i class="bi bi-stars"></i>
                    <h6>Top Rated</h6>
                    <p>Guest favorite stay</p>
                </div>
            </div>
        </div>
    </div>
</section>

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
