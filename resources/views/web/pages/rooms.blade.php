@extends('web.layouts.master')

@section('title', 'Our Rooms')

@section('content')
    <style>
        /* 🔥 Smooth hover effect for room images */
        .room-card img {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            border-radius: 8px;
        }

        .room-card:hover img {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .room-card {
            overflow: hidden;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .room-card:hover {
            transform: translateY(-5px);
        }
    </style>

    <div class="container mt-5">
        <h1 class="mb-4 text-center fw-bold">Our Luxurious Rooms</h1>
        <p class="text-center text-muted mb-5">
            Choose from our elegant range of rooms designed for comfort, style, and relaxation.
        </p>

        <div class="row">
            @foreach ($room as $rooms)
                <div class="col-md-4 mb-4">
                    <div class="card room-card shadow-sm border-0">
                            <img src="{{ asset('storage/' . $rooms->image) }}" class="card-img-top room-img" alt="{{ $rooms->type }}" style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h3 class="card-title text-primary">{{ $rooms->type }}</h3>
                            <h6 class="text-muted mb-2">A Touch of Luxury</h6>
                            <p style="padding:5px" class="card-text">{{ $rooms->description }}</p>

                            <div class="text-center mt-3">
                                <a class="btn btn-primary" href="{{ url('room_details', $rooms->id) }}">Room Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
