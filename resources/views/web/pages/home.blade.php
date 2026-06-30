@extends('web.layouts.master')

@section('title', 'Home')

@section('content')
<section class="home-hero">
    <img src="{{ asset('images/hotel-bg.jpg') }}" alt="Luxury Hotel" class="home-hero-bg">
    <div class="home-hero-overlay"></div>

    <div class="container home-hero-content">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <span class="home-badge">
                    <i class="bi bi-stars"></i> Premium Boutique Experience
                </span>
                <h1 class="home-title">Stay in comfort, style, and unforgettable hospitality.</h1>
                <p class="home-subtitle">
                    Discover beautifully designed rooms, modern amenities, and personalized service
                    tailored for business trips, romantic escapes, and family holidays.
                </p>

                <div class="home-actions">
                    <a href="{{ route('rooms') }}" class="btn home-btn-primary">
                        Explore Rooms
                    </a>
                    <a href="{{ route('contact') }}" class="btn home-btn-outline">
                        Plan Your Stay
                    </a>
                </div>

                <div class="home-trust">
                    <div><strong>4.9/5</strong> guest rating</div>
                    <div><strong>24/7</strong> concierge</div>
                    <div><strong>Best Price</strong> guarantee</div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="home-booking-card">
                    <h3>Book Your Room</h3>
                    <p>Reserve your perfect stay in just a few clicks.</p>
                    <form class="row g-3">
                        <div class="col-12">
                            <label for="arrival" class="form-label">Arrival</label>
                            <input type="date" id="arrival" name="arrival" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="departure" class="form-label">Departure</label>
                            <input type="date" id="departure" name="departure" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="guests" class="form-label">Guests</label>
                            <select id="guests" name="guests" class="form-select">
                                <option value="1">1 Guest</option>
                                <option value="2" selected>2 Guests</option>
                                <option value="3">3 Guests</option>
                                <option value="4">4 Guests</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn home-book-btn w-100">Check Availability</button>
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
            <div class="col-md-4">
                <div class="room-card">
                    <div class="room-card-body">
                        <h5>Deluxe Room</h5>
                        <p>Designed for guests who value comfort with modern elegance.</p>
                        <a href="{{ route('rooms') }}" class="room-link">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="room-card room-card-highlight">
                    <div class="room-card-body">
                        <h5>Executive Suite</h5>
                        <p>Spacious suite ideal for business stays and premium experiences.</p>
                        <a href="{{ route('rooms') }}" class="room-link">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="room-card">
                    <div class="room-card-body">
                        <h5>Family Residence</h5>
                        <p>Comfortable multi-bed space crafted for memorable family moments.</p>
                        <a href="{{ route('rooms') }}" class="room-link">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
