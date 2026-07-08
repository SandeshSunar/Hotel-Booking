@extends('web.layouts.master')

@section('title', 'Our Rooms')

@section('content')
    <section class="rooms-hero">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-9 text-center">
                    <span class="rooms-badge"><i class="bi bi-door-open-fill"></i> Our Rooms</span>
                    <h1 class="rooms-title">Discover Your Perfect Space to Relax</h1>
                    <p class="rooms-subtitle">
                        Browse all Single, Double, and Family rooms — each category has its own section with every available room listed separately.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="rooms-listing py-4">
        <div class="container">
            @php
                $sectionMeta = [
                    'single' => ['title' => 'Single Room', 'label' => 'Solo Stay', 'icon' => 'bi-person', 'theme' => 'single'],
                    'double' => ['title' => 'Double Room', 'label' => 'Couple Stay', 'icon' => 'bi-people', 'theme' => 'double'],
                    'family' => ['title' => 'Family Room', 'label' => 'Family Stay', 'icon' => 'bi-house-heart', 'theme' => 'family'],
                ];
            @endphp

            @foreach($sectionCategories as $category)
                @php
                    $rooms = $roomSections->get($category, collect());
                    $meta = $sectionMeta[$category];
                @endphp

                <div class="room-type-section room-type-section--{{ $meta['theme'] }}" id="{{ $category }}-rooms">
                    <div class="room-type-section-head">
                        <span class="room-type-section-badge">
                            <i class="bi {{ $meta['icon'] }}"></i> {{ $meta['label'] }}
                        </span>
                        <h2 class="room-type-section-title">{{ $meta['title'] }}</h2>
                        <p class="room-type-section-count mb-0">{{ $rooms->count() }} room{{ $rooms->count() === 1 ? '' : 's' }} available in this section</p>
                    </div>

                    @if($rooms->isNotEmpty())
                        <div class="row g-3">
                            @foreach($rooms as $roomType)
                                @php
                                    $image = $roomType->primary_image
                                        ? asset('storage/' . $roomType->primary_image)
                                        : asset('images/hotel-bg.jpg');
                                    $facilities = $roomType->facilities->take(3);
                                @endphp
                                <div class="col-sm-6 col-lg-4 col-xl-3">
                                    <article class="rooms-card rooms-card--compact h-100">
                                        <div class="rooms-image-wrap">
                                            <img src="{{ $image }}" class="rooms-image" alt="{{ $roomType->name }}">
                                            @if($roomType->room_number)
                                                <span class="rooms-image-tag">Room #{{ $roomType->room_number }}</span>
                                            @endif
                                        </div>
                                        <div class="rooms-card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h3 class="rooms-card-title mb-0">{{ $roomType->name }}</h3>
                                                <span class="badge {{ !$roomType->is_currently_booked ? 'bg-success' : 'bg-danger' }}">
                                                    {{ !$roomType->is_currently_booked ? 'Available' : 'Booked' }}
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <strong>Rs. {{ number_format($roomType->display_price, 2) }} / night</strong>
                                                @if($roomType->discount_price)
                                                    <small class="text-muted text-decoration-line-through ms-2">Rs. {{ number_format($roomType->price_per_night, 2) }}</small>
                                                @endif
                                            </div>
                                            <p class="small text-muted mb-2"><i class="bi bi-people"></i> {{ $roomType->capacity_label }}</p>
                                            <p class="rooms-card-text">{{ $roomType->short_description ?? \Illuminate\Support\Str::limit($roomType->description, 65) }}</p>
                                            @if($facilities->isNotEmpty())
                                                <ul class="list-unstyled rooms-card-facilities mb-2">
                                                    @foreach($facilities as $facility)
                                                        <li><i class="bi bi-check2-circle text-success me-1"></i> {{ $facility->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            <div class="d-flex flex-wrap gap-1 mt-auto rooms-card-actions">
                                                <a class="btn btn-sm rooms-card-btn" href="{{ route('room.details', $roomType->slug) }}">
                                                    View Details <i class="bi bi-arrow-right"></i>
                                                </a>
                                                @if(!$roomType->is_currently_booked)
                                                    <a class="btn btn-sm btn-outline-primary rounded-pill px-3" href="{{ route('room.details', $roomType->slug) }}#booking-form">
                                                        Book Now
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" disabled>
                                                        Booked
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="room-type-empty">
                            <p class="mb-0">No {{ strtolower($meta['title']) }}s added yet. Admin can add many rooms under this category.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endsection
