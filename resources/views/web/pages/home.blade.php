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
                            <div><strong>{{ number_format($averageRating, 1) }}/5</strong> guest rating</div>
                            <div><strong>{{ $totalReviews > 0 ? $totalReviews . '+' : 'No' }}</strong> reviews</div>
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

                                @if($roomType->reviews->count() > 0)
                                    <div class="mb-3 small">
                                        <div class="star-rating text-warning d-inline-block">
                                            @php $avgRoomRating = round($roomType->reviews->avg('rating')); @endphp
                                            @for($i = 0; $i < $avgRoomRating; $i++) <i class="bi bi-star-fill"></i> @endfor
                                            @for($i = $avgRoomRating; $i < 5; $i++) <i class="bi bi-star text-secondary opacity-25"></i> @endfor
                                        </div>
                                        <span class="text-muted ms-1">({{ $roomType->reviews->count() }} {{ Str::plural('review', $roomType->reviews->count()) }})</span>
                                    </div>
                                @endif
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

    @if($allReviews->count() > 0)
    <section class="home-reviews py-5" id="guest-reviews">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-tag" style="color: #6366f1; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Testimonials</span>
                <h2 class="section-title fw-bold">What Our Guests Say</h2>
                <p class="text-muted mt-2">Real experiences from our valued guests — read their stories below.</p>
            </div>

            {{-- Rating Overview Stats --}}
            <div class="row g-4 mb-5 justify-content-center">
                <div class="col-lg-4 col-md-5">
                    <div class="rating-overview-card text-center p-4 rounded-4 h-100">
                        <div class="rating-big-number">{{ number_format($averageRating, 1) }}</div>
                        <div class="star-rating text-warning mb-2" style="font-size: 1.3rem;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($averageRating))
                                    <i class="bi bi-star-fill"></i>
                                @else
                                    <i class="bi bi-star text-secondary opacity-25"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-muted mb-0">Based on <strong>{{ $totalReviews }}</strong> {{ Str::plural('review', $totalReviews) }}</p>
                    </div>
                </div>
                <div class="col-lg-5 col-md-7">
                    <div class="rating-bars-card p-4 rounded-4 h-100">
                        @for($star = 5; $star >= 1; $star--)
                            @php $barPercent = $totalReviews > 0 ? ($ratingDistribution[$star] / $totalReviews) * 100 : 0; @endphp
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="rating-bar-label">{{ $star }} <i class="bi bi-star-fill text-warning" style="font-size: .7rem;"></i></span>
                                <div class="rating-bar-track flex-grow-1">
                                    <div class="rating-bar-fill" style="width: {{ $barPercent }}%;"></div>
                                </div>
                                <span class="rating-bar-count">{{ $ratingDistribution[$star] }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Reviews Carousel --}}
            <div class="reviews-carousel-wrapper">
                <div class="reviews-carousel" id="reviewsCarousel">
                    <div class="reviews-carousel-track">
                        @foreach($allReviews as $review)
                            <div class="reviews-carousel-card">
                                <div class="review-card-inner">
                                    <div class="review-quote-icon"><i class="bi bi-quote"></i></div>
                                    <p class="review-card-comment">"{{ Str::limit($review->comment, 180) }}"</p>
                                    <div class="review-card-footer">
                                        <div class="review-card-avatar">{{ strtoupper(mb_substr($review->name, 0, 1)) }}</div>
                                        <div class="review-card-info">
                                            <h6 class="review-card-name">{{ $review->name }}</h6>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="star-rating text-warning" style="font-size: 0.75rem;">
                                                    @for($i = 0; $i < $review->rating; $i++) <i class="bi bi-star-fill"></i> @endfor
                                                    @for($i = $review->rating; $i < 5; $i++) <i class="bi bi-star text-secondary opacity-25"></i> @endfor
                                                </div>
                                                @if($review->roomType)
                                                    <span class="review-room-badge">{{ $review->roomType->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <small class="review-card-date">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- Duplicate for infinite scroll effect --}}
                        @foreach($allReviews as $review)
                            <div class="reviews-carousel-card">
                                <div class="review-card-inner">
                                    <div class="review-quote-icon"><i class="bi bi-quote"></i></div>
                                    <p class="review-card-comment">"{{ Str::limit($review->comment, 180) }}"</p>
                                    <div class="review-card-footer">
                                        <div class="review-card-avatar">{{ strtoupper(mb_substr($review->name, 0, 1)) }}</div>
                                        <div class="review-card-info">
                                            <h6 class="review-card-name">{{ $review->name }}</h6>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="star-rating text-warning" style="font-size: 0.75rem;">
                                                    @for($i = 0; $i < $review->rating; $i++) <i class="bi bi-star-fill"></i> @endfor
                                                    @for($i = $review->rating; $i < 5; $i++) <i class="bi bi-star text-secondary opacity-25"></i> @endfor
                                                </div>
                                                @if($review->roomType)
                                                    <span class="review-room-badge">{{ $review->roomType->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <small class="review-card-date">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="reviews-carousel-fade reviews-carousel-fade--left"></div>
                <div class="reviews-carousel-fade reviews-carousel-fade--right"></div>
            </div>

            {{-- Navigation Controls --}}
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button class="reviews-nav-btn" onclick="scrollReviews(-1)" aria-label="Previous reviews">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="reviews-nav-btn" onclick="scrollReviews(1)" aria-label="Next reviews">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <style>
        /* Reviews Section */
        .home-reviews {
            background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 50%, #fff7ed 100%);
            position: relative;
            overflow: hidden;
        }
        .home-reviews::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Rating Overview */
        .rating-overview-card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(148,163,184,0.15);
            box-shadow: 0 8px 32px rgba(15,23,42,0.06);
        }
        .rating-big-number {
            font-size: 3.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        /* Rating Bars */
        .rating-bars-card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(148,163,184,0.15);
            box-shadow: 0 8px 32px rgba(15,23,42,0.06);
        }
        .rating-bar-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #334155;
            min-width: 36px;
            display: flex;
            align-items: center;
            gap: 3px;
        }
        .rating-bar-track {
            height: 10px;
            background: #e2e8f0;
            border-radius: 99px;
            overflow: hidden;
        }
        .rating-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #fbbf24, #f59e0b);
            border-radius: 99px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .rating-bar-count {
            font-weight: 600;
            font-size: 0.8rem;
            color: #64748b;
            min-width: 24px;
            text-align: right;
        }

        /* Reviews Carousel */
        .reviews-carousel-wrapper {
            position: relative;
            overflow: hidden;
        }
        .reviews-carousel {
            overflow: hidden;
            width: 100%;
        }
        .reviews-carousel-track {
            display: flex;
            gap: 1.25rem;
            animation: scrollReviews {{ $allReviews->count() * 5 }}s linear infinite;
            width: max-content;
        }
        .reviews-carousel-track:hover {
            animation-play-state: paused;
        }

        @keyframes scrollReviews {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .reviews-carousel-card {
            flex: 0 0 360px;
            max-width: 360px;
        }

        .review-card-inner {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            border-radius: 1.25rem;
            padding: 1.75rem;
            border: 1px solid rgba(148,163,184,0.15);
            box-shadow: 0 8px 30px rgba(15,23,42,0.06);
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .review-card-inner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #6366f1, #a855f7, #ec4899);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .review-card-inner:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(99, 102, 241, 0.15);
        }
        .review-card-inner:hover::before {
            opacity: 1;
        }

        .review-quote-icon {
            font-size: 2rem;
            color: #6366f1;
            opacity: 0.2;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        .review-card-comment {
            color: #374151;
            font-size: 0.95rem;
            line-height: 1.65;
            flex: 1;
            margin-bottom: 1.25rem;
            font-style: italic;
        }
        .review-card-footer {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        .review-card-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .review-card-info {
            flex: 1;
            min-width: 0;
        }
        .review-card-name {
            font-weight: 700;
            font-size: 0.9rem;
            color: #0f172a;
            margin: 0;
        }
        .review-room-badge {
            font-size: 0.65rem;
            padding: 2px 8px;
            background: rgba(99, 102, 241, 0.08);
            color: #6366f1;
            border-radius: 99px;
            font-weight: 600;
        }
        .review-card-date {
            color: #94a3b8;
            font-size: 0.75rem;
            white-space: nowrap;
        }

        /* Fade edges */
        .reviews-carousel-fade {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 80px;
            pointer-events: none;
            z-index: 2;
        }
        .reviews-carousel-fade--left {
            left: 0;
            background: linear-gradient(90deg, #f0f4ff 0%, transparent 100%);
        }
        .reviews-carousel-fade--right {
            right: 0;
            background: linear-gradient(-90deg, #f0f4ff 0%, transparent 100%);
        }

        /* Nav Buttons */
        .reviews-nav-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 2px solid rgba(99, 102, 241, 0.2);
            background: rgba(255,255,255,0.9);
            color: #6366f1;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
        }
        .reviews-nav-btn:hover {
            background: #6366f1;
            color: #fff;
            border-color: #6366f1;
            transform: scale(1.1);
        }

        @media (max-width: 576px) {
            .reviews-carousel-card {
                flex: 0 0 280px;
                max-width: 280px;
            }
            .rating-big-number {
                font-size: 2.5rem;
            }
            .reviews-carousel-fade {
                width: 40px;
            }
        }
    </style>

    <script>
        function scrollReviews(direction) {
            const track = document.querySelector('.reviews-carousel-track');
            const cardWidth = 360 + 20; // card width + gap
            track.style.animationPlayState = 'paused';
            const currentTransform = getComputedStyle(track).transform;
            const matrix = new DOMMatrix(currentTransform);
            const currentX = matrix.m41;
            const newX = currentX + (direction * -cardWidth);
            track.style.animation = 'none';
            track.style.transform = `translateX(${newX}px)`;
            track.style.transition = 'transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            setTimeout(() => {
                track.style.transition = '';
                track.style.transform = '';
                track.style.animation = '';
            }, 3000);
        }
    </script>
    @endif


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
