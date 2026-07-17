@extends('web.layouts.master')

@section('title', 'Home')

@section('content')
    <section class="home-hero">
        <img src="{{ asset('images/hotel-bg.jpg') }}" alt="Luxury Hotel" class="home-hero-bg">
        <div class="home-hero-overlay"></div>

        <div class="container home-hero-content">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="home-hero-top">
                        
                        <h1 class="home-title text-center">Find your perfect stay at our hotel</h1>
                        <p class="home-subtitle text-center">
                            Modern rooms, friendly staff and a prime location for business, family and leisure trips.
                        </p>
                        <div class="home-trust justify-content-center">
                            <div><strong>4.9/5</strong> guest rating</div>
                            <div><strong>1k+</strong> happy stays</div>
                            <div><strong>24/7</strong> support</div>
                        </div>
                    </div>

                    <div class="home-search-card">
                        <form class="row g-3 align-items-center">
                            <div class="col-md-4 home-search-field">
                                <label for="arrival" class="form-label">Check-in</label>
                                <input type="date" id="arrival" name="arrival" class="form-control" required>
                            </div>
                            <div class="col-md-4 home-search-field">
                                <label for="departure" class="form-label">Check-out</label>
                                <input type="date" id="departure" name="departure" class="form-control" required>
                            </div>
                            <div class="col-md-3 home-search-field">
                                <label for="guests" class="form-label">Guests</label>
                                <select id="guests" name="guests" class="form-select">
                                    <option value="1">1 Guest</option>
                                    <option value="2" selected>2 Guests</option>
                                    <option value="3">3 Guests</option>
                                    <option value="4">4 Guests</option>
                                </select>
                            </div>
                            <div class="col-md-1 d-grid">
                                <button type="submit" class="btn home-book-btn">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-features py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <span class="feature-icon"><i class="bi bi-building-check"></i></span>
                        <h4>Elegant Rooms</h4>
                        <p>Carefully curated interiors with luxury bedding and calming ambiance.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <span class="feature-icon"><i class="bi bi-cup-hot"></i></span>
                        <h4>Fine Dining</h4>
                        <p>Freshly prepared cuisine and handcrafted beverages all day long.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <span class="feature-icon"><i class="bi bi-water"></i></span>
                        <h4>Wellness & Leisure</h4>
                        <p>Relax in spa-inspired spaces and enjoy modern recreational facilities.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-rooms py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-tag">Popular Stays</span>
                <h2 class="section-title">Choose Your Perfect Room</h2>
            </div>
            <div class="row g-4">
                @forelse ($featuredRooms as $roomType)
                    <div class="col-md-4">
                        <div class="room-card h-100">
                            <div class="ratio ratio-16x9 rounded-top overflow-hidden">
                                <img src="{{ $roomType->primary_image ? asset('storage/' . $roomType->primary_image) : asset('images/hotel-bg.jpg') }}"
                                    alt="{{ $roomType->name }}" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div class="room-card-body">
                                <span class="badge mb-2 {{ !$roomType->is_currently_booked ? 'bg-success' : 'bg-danger' }}">
                                    {{ !$roomType->is_currently_booked ? 'Available' : 'Booked' }}
                                </span>
                                <h5>{{ $roomType->name }}</h5>
                                <p>{{ Str::limit($roomType->short_description ?? $roomType->description, 95) }}</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <strong>Rs. {{ number_format($roomType->display_price, 2) }} / night</strong>
                                    <small class="text-muted">{{ $roomType->capacity_label }}</small>
                                </div>
                                <div class="room-link-wrap">
                                    <a href="{{ route('room.details', $roomType->slug) }}" class="room-link">
                                        View Details <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0">
                            No rooms have been added yet. Once the admin uploads rooms, they will appear here.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="room-link-wrap py-4" style="text-align: center;">
            <a href="{{ route('rooms') }}" class="room-link">
                View All Rooms <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </section>

    <section class="hotel-amenities py-5" style="background-color: #f8fafc;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-tag" style="color: #6366f1; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Discover More</span>
                <h2 class="section-title fw-bold">Attractive Features</h2>
                <p class="text-muted mt-2">Everything you need for an unforgettable and comfortable stay.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="amenity-item text-center p-5 bg-white rounded-4 shadow-sm border border-light h-100 feature-glass">
                        <div class="icon-wrap mb-4 mx-auto d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width: 80px; height: 80px;">
                            <i class="bi bi-wifi" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Free High-Speed Wi-Fi</h5>
                        <p class="text-muted mb-0">Stay connected with our seamless internet connection anywhere in the hotel.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="amenity-item text-center p-5 bg-white rounded-4 shadow-sm border border-light h-100 feature-glass">
                        <div class="icon-wrap mb-4 mx-auto d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width: 80px; height: 80px;">
                            <i class="bi bi-car-front" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Airport Transfers</h5>
                        <p class="text-muted mb-0">Complimentary pick-up and drop-off to make your journey smoother.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="amenity-item text-center p-5 bg-white rounded-4 shadow-sm border border-light h-100 feature-glass">
                        <div class="icon-wrap mb-4 mx-auto d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-check" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">24/7 Security</h5>
                        <p class="text-muted mb-0">Advanced surveillance and trained personnel for a completely safe stay.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="amenity-item text-center p-5 bg-white rounded-4 shadow-sm border border-light h-100 feature-glass">
                        <div class="icon-wrap mb-4 mx-auto d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width: 80px; height: 80px;">
                            <i class="bi bi-tv" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Smart Entertainment</h5>
                        <p class="text-muted mb-0">Large flat-screen TVs with premium streaming services included.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="amenity-item text-center p-5 bg-white rounded-4 shadow-sm border border-light h-100 feature-glass">
                        <div class="icon-wrap mb-4 mx-auto d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width: 80px; height: 80px;">
                            <i class="bi bi-bicycle" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">City Tours & Rentals</h5>
                        <p class="text-muted mb-0">Bicycle and car rentals for convenient local exploration.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="amenity-item text-center p-5 bg-white rounded-4 shadow-sm border border-light h-100 feature-glass">
                        <div class="icon-wrap mb-4 mx-auto d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width: 80px; height: 80px;">
                            <i class="bi bi-water" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Infinity Swimming Pool</h5>
                        <p class="text-muted mb-0">Take a refreshing dip in our temperature-controlled pool offering stunning city views.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .amenity-item { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .amenity-item:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important; border-color: rgba(99, 102, 241, 0.6) !important; z-index: 10; position: relative;}
        .amenity-item .icon-wrap { transition: all 0.3s ease; }
        .amenity-item:hover .icon-wrap { transform: scale(1.15) rotate(5deg); background-color: var(--bs-primary) !important; color: white !important;}
        .feature-glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
@endsection
