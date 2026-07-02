@extends('web.layouts.master')

@section('title', 'Room Details')

@section('content')
    @php
        $roomName = \Illuminate\Support\Str::headline($room->type);
        $roomImage = $room->image ? asset('storage/' . $room->image) : asset('images/hotel-bg.jpg');
        $isAvailable = $room->status === 'available';

        $highlights = [
            [
                'icon' => 'bi-stars',
                'title' => 'Elegant Stay',
                'text' => 'Designed for guests who want a calm, refined, and comfortable experience.',
            ],
            [
                'icon' => 'bi-wifi',
                'title' => 'Fast Wi-Fi',
                'text' => $room->wifi
                    ? 'High-speed wireless internet is available throughout the room.'
                    : 'Wi-Fi access can be arranged on request.',
            ],
            [
                'icon' => 'bi-shield-check',
                'title' => 'Secure & Private',
                'text' => 'A private space with secure access and attentive service during your stay.',
            ],
        ];

        $facilities = [
            ['icon' => 'bi-snow2', 'label' => 'Air conditioning'],
            ['icon' => 'bi-tv', 'label' => 'Smart TV entertainment'],
            ['icon' => 'bi-cup-hot', 'label' => 'Tea and coffee setup'],
            ['icon' => 'bi-lightning-charge', 'label' => 'Fast charging points'],
            ['icon' => 'bi-droplet-half', 'label' => 'Fresh bathroom essentials'],
            ['icon' => 'bi-door-open', 'label' => 'Private room access'],
        ];

        $amenities = [
            ['icon' => 'bi-check2-circle', 'label' => 'Comfort-first bedding'],
            ['icon' => 'bi-check2-circle', 'label' => 'Modern interiors'],
            ['icon' => 'bi-check2-circle', 'label' => 'Daily housekeeping'],
            ['icon' => 'bi-check2-circle', 'label' => '24/7 front desk support'],
        ];
    @endphp

    <style>
        .room-page {
            position: relative;
            overflow: hidden;
            padding: 4.5rem 0 5rem;
            background:
                radial-gradient(circle at top left, rgba(14, 165, 233, 0.14), transparent 26%),
                radial-gradient(circle at top right, rgba(32, 201, 151, 0.14), transparent 22%),
                linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
        }

        .room-page::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255, 255, 255, 0.45) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.45) 1px, transparent 1px);
            background-size: 54px 54px;
            mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.35), transparent 70%);
            pointer-events: none;
        }

        .room-shell {
            position: relative;
            z-index: 1;
        }

        .room-hero {
            margin-bottom: 1.5rem;
            padding: 1.5rem 1.5rem 1.75rem;
            border-radius: 1.6rem;
            background: rgba(255, 255, 255, 0.84);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 22px 60px rgba(15, 23, 42, 0.08);
        }

        .room-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(13, 110, 253, 0.08);
            color: #0d6efd;
            font-weight: 700;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .room-title {
            color: #0f172a;
            font-size: clamp(2.2rem, 4vw, 3.6rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.75rem;
        }

        .room-subtitle {
            max-width: 760px;
            color: #475569;
            margin: 0 auto;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .room-image-card,
        .room-info-card,
        .room-booking-card,
        .room-block {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 1.4rem;
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.07);
        }

        .room-image-wrap {
            position: relative;
            overflow: hidden;
            border-radius: 1.35rem;
        }

        .room-image {
            width: 100%;
            height: 100%;
            max-height: 520px;
            object-fit: cover;
            display: block;
        }

        .room-image-overlay {
            position: absolute;
            inset: auto 1rem 1rem 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
        }

        .room-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 0.85rem;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.82);
            color: #fff;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .room-chip.soft {
            background: rgba(255, 255, 255, 0.9);
            color: #0f172a;
        }

        .room-info-card {
            padding: 1.25rem;
        }

        .room-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .room-meta-item {
            padding: 1rem;
            border-radius: 1rem;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .room-meta-item span {
            display: block;
            font-size: 0.82rem;
            color: #64748b;
            margin-bottom: 0.3rem;
        }

        .room-meta-item strong {
            color: #0f172a;
            font-size: 1rem;
        }

        .room-booking-card {
            padding: 1.4rem;
            position: sticky;
            top: 1.25rem;
        }

        .room-booking-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.35rem;
        }

        .room-booking-subtitle {
            color: #64748b;
            margin-bottom: 1rem;
        }

        .room-booking-form .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #344054;
        }

        .room-booking-form .form-control {
            border-radius: 0.95rem;
            border: 1.4px solid #e4e9f2;
            padding: 0.85rem 1rem;
            background: #f8fafc;
            box-shadow: none;
        }

        .room-booking-form .form-control:focus {
            border-color: rgba(13, 110, 253, 0.55);
            background: #fff;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
        }

        .room-booking-btn {
            border: 0;
            border-radius: 0.95rem;
            padding: 0.9rem 1rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #0d6efd 0%, #20c997 100%);
            box-shadow: 0 12px 26px rgba(13, 110, 253, 0.25);
        }

        .room-booking-btn:hover {
            color: #fff;
        }

        .room-section {
            margin-top: 1.5rem;
        }

        .room-section-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.75rem;
        }

        .room-section-text {
            color: #475569;
            line-height: 1.8;
            margin-bottom: 0;
        }

        .room-highlight-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .room-highlight-card {
            padding: 1rem;
            border-radius: 1.1rem;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.05);
            height: 100%;
        }

        .room-highlight-icon {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(13, 110, 253, 0.08);
            color: #0d6efd;
            font-size: 1.1rem;
            margin-bottom: 0.9rem;
        }

        .room-highlight-card h6 {
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.45rem;
        }

        .room-highlight-card p {
            color: #64748b;
            margin: 0;
            line-height: 1.7;
            font-size: 0.95rem;
        }

        .room-facility-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .room-facility-item {
            display: flex;
            align-items: flex-start;
            gap: 0.7rem;
            padding: 0.95rem 1rem;
            border-radius: 1rem;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .room-facility-item i {
            color: #16a34a;
            font-size: 1.05rem;
            margin-top: 0.15rem;
        }

        .room-facility-item span {
            color: #0f172a;
            font-weight: 600;
        }

        .room-amenity-list {
            display: grid;
            gap: 0.75rem;
        }

        .room-amenity-item {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.85rem 1rem;
            border-radius: 0.95rem;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.12);
            color: #0f172a;
            font-weight: 600;
        }

        .room-amenity-item i {
            color: #0d6efd;
        }

        .room-booking-note {
            padding: 0.9rem 1rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.08), rgba(32, 201, 151, 0.08));
            color: #0f172a;
            font-weight: 600;
            margin-top: 1rem;
        }

        @media (max-width: 991.98px) {
            .room-booking-card {
                position: static;
            }

            .room-highlight-grid,
            .room-facility-list {
                grid-template-columns: 1fr;
            }

            .room-meta-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="room-page">
        <div class="container room-shell">
            <div class="room-hero text-center">
                <span class="room-badge"><i class="bi bi-stars"></i> Modern Room Experience</span>
                <h1 class="room-title">{{ $roomName }}</h1>
                <p class="room-subtitle">
                    A refined and modern stay designed with comfort, style, and essential facilities for today’s guest.
                </p>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-12 col-lg-7">
                    <div class="room-image-card p-3">
                        <div class="room-image-wrap">
                            <img src="{{ $roomImage }}" class="room-image" alt="{{ $roomName }}">
                            <div class="room-image-overlay">
                                <span class="room-chip">Rs. {{ number_format($room->price, 2) }} / night</span>
                                <span class="room-chip soft">
                                    <i class="bi {{ $isAvailable ? 'bi-check-circle' : 'bi-slash-circle' }}"></i>
                                    {{ ucfirst($room->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="room-section room-block p-4 mt-4">
                        <h2 class="room-section-title">Designed for a better stay</h2>
                        <p class="room-section-text">
                            {{ $room->description ?: 'This room combines a contemporary interior with a warm atmosphere, making it ideal for restful nights and productive travel days.' }}
                        </p>
                    </div>

                    <div class="room-section">
                        <div class="room-highlight-grid">
                            @foreach ($highlights as $highlight)
                                <div class="room-highlight-card">
                                    <div class="room-highlight-icon">
                                        <i class="bi {{ $highlight['icon'] }}"></i>
                                    </div>
                                    <h6>{{ $highlight['title'] }}</h6>
                                    <p>{{ $highlight['text'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="room-section room-block p-4 mt-4">
                        <h2 class="room-section-title">Modern facilities included</h2>
                        <div class="room-facility-list">
                            @foreach ($facilities as $facility)
                                <div class="room-facility-item">
                                    <i class="bi {{ $facility['icon'] }}"></i>
                                    <span>{{ $facility['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="room-section room-block p-4 mt-4">
                        <h2 class="room-section-title">General comfort features</h2>
                        <div class="room-amenity-list">
                            @foreach ($amenities as $amenity)
                                <div class="room-amenity-item">
                                    <i class="bi {{ $amenity['icon'] }}"></i>
                                    <span>{{ $amenity['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="room-booking-card">
                        <h4 class="room-booking-title">Reserve this room</h4>
                        <p class="room-booking-subtitle">Fast booking with clear room details and available amenities.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger room-booking-alert">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success text-center room-booking-alert" id="success-message">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('booking.submit') }}" method="POST" onsubmit="return validateForm()"
                            class="room-booking-form">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">

                            <div class="mb-3">
                                <label for="guest_name" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="guest_name" name="guest_name"
                                    placeholder="Enter your full name" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="10-digit number" required>
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

                        <div class="room-booking-note">
                            Modern comfort, secure booking, and flexible room selection made simple.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function validateForm() {
            const name = document.getElementById('guest_name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;

            const namePattern = /^[A-Za-z\s]+$/;
            if (!namePattern.test(name)) {
                alert('Name must contain only letters.');
                return false;
            }

            const phonePattern = /^[0-9]{10}$/;
            if (!phonePattern.test(phone)) {
                alert('Phone number must be exactly 10 digits.');
                return false;
            }

            if (new Date(checkIn) >= new Date(checkOut)) {
                alert('End date must be after start date.');
                return false;
            }

            return true;
        }
    </script>
@endsection
