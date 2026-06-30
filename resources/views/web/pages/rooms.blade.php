@extends('web.layouts.master')

@section('title', 'Our Rooms')

@section('content')
<section class="rooms-hero">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9 text-center">
                <span class="rooms-badge"><i class="bi bi-door-open-fill"></i> Our Rooms</span>
                <h1 class="rooms-title">Discover Your Perfect Space to Relax</h1>
                <p class="rooms-subtitle">
                    From cozy comfort to premium luxury, every room is thoughtfully designed with elegant
                    interiors and modern amenities for a memorable stay.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="rooms-listing py-5">
    <div class="container">
        <div class="row g-4">
            @foreach ($room as $rooms)
                <div class="col-md-6 col-lg-4">
                    <article class="rooms-card h-100">
                        <div class="rooms-image-wrap">
                            <img src="{{ asset('storage/' . $rooms->image) }}" class="rooms-image" alt="{{ $rooms->type }}">
                            <span class="rooms-image-tag">Premium Stay</span>
                        </div>
                        <div class="rooms-card-body">
                            <h3 class="rooms-card-title">{{ $rooms->type }}</h3>
                            <p class="rooms-card-text">{{ $rooms->description }}</p>
                            <a class="btn rooms-card-btn" href="{{ url('room_details', $rooms->id) }}">
                                Room Details <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
