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
                    <span class="home-badge">
                        <i class="bi bi-stars"></i> Premium Boutique Experience
                    </span>
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
