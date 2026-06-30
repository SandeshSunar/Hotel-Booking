@extends('web.layouts.master')

@section('title', 'About Us')

@section('content')
<section class="about-hero">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="about-badge"><i class="bi bi-building-heart"></i> About Our Hotel</span>
                <h1 class="about-title">A modern stay experience built on comfort and genuine hospitality.</h1>
                <p class="about-lead">
                    At <strong>MyHotel</strong>, we combine elegant interiors, thoughtful service, and a welcoming
                    atmosphere to make every guest feel at home from check-in to check-out.
                </p>
                <div class="about-hero-actions">
                    <a href="{{ route('rooms') }}" class="btn about-btn-primary">View Rooms</a>
                    <a href="{{ route('contact') }}" class="btn about-btn-outline">Contact Us</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image-wrap">
                    <img src="{{ asset('images/about.png') }}" alt="About MyHotel" class="img-fluid about-image-main">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-story py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="about-info-card">
                    <span class="about-info-icon"><i class="bi bi-stars"></i></span>
                    <h4>Luxury Comfort</h4>
                    <p>Premium bedding, carefully designed rooms, and details that elevate every stay.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-info-card">
                    <span class="about-info-icon"><i class="bi bi-cup-hot"></i></span>
                    <h4>Curated Dining</h4>
                    <p>Fresh cuisine and warm dining spaces designed for relaxing moments.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-info-card">
                    <span class="about-info-icon"><i class="bi bi-person-check"></i></span>
                    <h4>Guest-First Service</h4>
                    <p>Friendly, responsive team available around the clock for your needs.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-values py-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <h2 class="about-section-title">Why guests choose MyHotel</h2>
                <p class="about-section-text">
                    We are a single-property hotel focused on quality over quantity. Every room, amenity, and
                    interaction is designed to create a comfortable and memorable experience for families, business
                    travelers, and couples.
                </p>
                <ul class="about-points">
                    <li><i class="bi bi-check-circle-fill"></i> Prime location with easy city access</li>
                    <li><i class="bi bi-check-circle-fill"></i> Fast check-in and personalized support</li>
                    <li><i class="bi bi-check-circle-fill"></i> Clean, modern spaces with premium amenities</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="about-stats-grid">
                    <div class="about-stat-card">
                        <h3>1,200+</h3>
                        <p>Happy Guests</p>
                    </div>
                    <div class="about-stat-card">
                        <h3>4.9/5</h3>
                        <p>Average Rating</p>
                    </div>
                    <div class="about-stat-card">
                        <h3>24/7</h3>
                        <p>Front Desk</p>
                    </div>
                    <div class="about-stat-card">
                        <h3>100%</h3>
                        <p>Comfort Focus</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
