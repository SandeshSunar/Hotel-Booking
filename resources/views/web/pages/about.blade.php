@extends('web.layouts.master')

@section('title', 'About Us')

@section('content')
<style>
    /* 🔹 About Page Inline Styles */
    .about-image-wrapper {
        overflow: hidden;
        border-radius: 12px;
    }

    .about-image {
        width: 100%;
        border-radius: 12px;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .about-image:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
</style>

<div class="container py-5">
    <div class="row align-items-center">
        <!-- Left Side Image -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="about-image-wrapper">
                <img src="{{ asset('images/about.png') }}" 
                     alt="About MyHotel" 
                     class="img-fluid rounded shadow-lg about-image">
            </div>
        </div>

        <!-- Right Side Text -->
        <div class="col-md-6 text-dark">
            <h1 class="fw-bold mb-3">About <span class="text-primary">MyHotel</span></h1>
            <p class="fs-5">
                Welcome to <strong>MyHotel</strong>, where timeless elegance meets modern comfort. 
                Nestled in the heart of the city, our hotel offers beautifully designed rooms, 
                warm hospitality, and exceptional service to make every stay unforgettable.
            </p>
            <p class="fs-5">
                Whether you’re here for business or leisure, MyHotel promises a relaxing escape 
                with world-class dining, serene ambiance, and attention to every detail that makes 
                you feel right at home.
            </p>
        </div>
    </div>
</div>
@endsection
