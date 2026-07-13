@extends('web.layouts.master')

@section('title', $roomType->name)

@section('content')
@php
    $primaryImage = $roomType->primary_image
        ? asset('storage/' . $roomType->primary_image)
        : asset('images/hotel-bg.jpg');
    $isAvailable = !$roomType->is_currently_booked && $roomType->is_active;
@endphp

<style>
    .room-page { padding: 4rem 0 5rem; background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%); }
    .room-hero, .room-block, .room-booking-card { background: #fff; border-radius: 1.25rem; box-shadow: 0 16px 40px rgba(15,23,42,.06); border: 1px solid rgba(148,163,184,.16); }
    .room-hero { padding: 1.5rem; margin-bottom: 1.5rem; }
    .room-title { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; color: #0f172a; }
    .room-gallery img { width: 100%; height: 220px; object-fit: cover; border-radius: 1rem; }
    .room-meta { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .room-meta-item { background: #f8fafc; border-radius: .9rem; padding: 1rem; }
    .room-facility-item { display: flex; gap: .6rem; align-items: center; padding: .75rem 0; border-bottom: 1px solid #eef2f7; }
    .room-booking-card { padding: 1.5rem; position: sticky; top: 1rem; }
    @media (max-width: 991px) { .room-meta { grid-template-columns: 1fr; } .room-booking-card { position: static; } }
</style>

<section class="room-page">
    <div class="container">
        <div class="room-hero text-center">
            <span class="badge {{ $isAvailable ? 'bg-primary-subtle text-primary' : 'bg-danger text-white' }} mb-2">
                {{ $isAvailable ? $roomType->name : 'Booked' }}
            </span>
            <h1 class="room-title">{{ $roomType->name }}</h1>
            <p class="text-muted mb-0">{{ $roomType->short_description ?? 'A dedicated stay experience with its own facilities, pricing, and comfort.' }}</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="room-block p-3 mb-4">
                    <img src="{{ $primaryImage }}" alt="{{ $roomType->name }}" class="w-100 rounded-4 mb-3" style="max-height:420px; object-fit:cover;">
                    @if($roomType->images->count() > 1)
                        <div class="row g-3 room-gallery">
                            @foreach($roomType->images->skip(1) as $image)
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $roomType->name }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="room-block p-4 mb-4">
                    <h4 class="fw-bold mb-3">About this room</h4>
                    <p class="mb-0">{{ $roomType->description }}</p>
                </div>

                <div class="room-block p-4 mb-4">
                    <h4 class="fw-bold mb-3">Room details</h4>
                    <div class="room-meta">
                        <div class="room-meta-item"><small class="text-muted">Capacity</small><div class="fw-bold">{{ $roomType->capacity_label }}</div></div>
                        <div class="room-meta-item"><small class="text-muted">Room Size</small><div class="fw-bold">{{ $roomType->room_size ?? 'N/A' }}</div></div>
                        <div class="room-meta-item"><small class="text-muted">Bed Type</small><div class="fw-bold">{{ $roomType->bed_type ?? 'N/A' }}</div></div>
                    </div>
                </div>

                <div class="room-block p-4">
                    <h4 class="fw-bold mb-3">Facilities</h4>
                    @forelse($roomType->facilities as $facility)
                        <div class="room-facility-item">
                            <i class="bi {{ $facility->icon ?? 'bi-check2-circle' }} text-success"></i>
                            <span>{{ $facility->name }}</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Facilities will be updated soon.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-5">
                <div class="room-booking-card" id="booking-form">
                    <h4 class="fw-bold">Reserve {{ $roomType->name }}</h4>
                    <p class="text-muted">Rs. {{ number_format($roomType->display_price, 2) }} / night</p>


                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('booking.submit') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Check-in Date</label>
                                <input type="date" name="check_in" id="check_in" class="form-control" value="{{ old('check_in') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Check-out Date</label>
                                <input type="date" name="check_out" id="check_out" class="form-control" value="{{ old('check_out') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Adults</label>
                                <input type="number" name="adults" min="1" max="{{ $roomType->capacity_adults }}" class="form-control" value="{{ old('adults', 1) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Children</label>
                                <input type="number" name="children" min="0" max="{{ $roomType->capacity_children }}" class="form-control" value="{{ old('children', 0) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Rooms</label>
                                <input type="number" name="rooms_count" min="1" max="{{ $roomType->total_rooms }}" class="form-control" value="{{ old('rooms_count', 1) }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Guest Name</label>
                                <input type="text" name="guest_name" class="form-control" value="{{ old('guest_name', auth()->user()->name ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Special Requests</label>
                                <textarea name="special_requests" rows="3" class="form-control">{{ old('special_requests') }}</textarea>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-light border mb-0">
                                    <strong>Total Price:</strong> <span id="totalPrice">Rs. {{ number_format($roomType->display_price, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-12 gap-2 d-flex">
                                <button type="submit" class="btn {{ $isAvailable ? 'btn-primary' : 'btn-danger' }} w-100" {{ $isAvailable ? '' : 'disabled' }}>
                                    {{ $isAvailable ? 'Book Now' : 'Booked' }}
                                </button>
                                <a href="{{ route('rooms') }}" class="btn btn-secondary w-100">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const pricePerNight = {{ $roomType->display_price }};
const checkIn = document.getElementById('check_in');
const checkOut = document.getElementById('check_out');
const roomsCount = document.querySelector('[name="rooms_count"]');
const totalPrice = document.getElementById('totalPrice');

function updateTotal() {
    if (!checkIn.value || !checkOut.value) return;
    const start = new Date(checkIn.value);
    const end = new Date(checkOut.value);
    const nights = Math.max(1, Math.ceil((end - start) / (1000 * 60 * 60 * 24)));
    const total = pricePerNight * nights * (parseInt(roomsCount.value || 1));
    totalPrice.textContent = 'Rs. ' + total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

[checkIn, checkOut, roomsCount].forEach(el => el.addEventListener('change', updateTotal));
</script>
@endsection
