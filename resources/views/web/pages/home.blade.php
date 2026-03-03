@extends('web.layouts.master')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div class="position-relative" style="height: 100vh; overflow: hidden;">
    <!-- Background Image -->
    <img src="{{ asset('images/hotel-bg.jpg') }}" 
         alt="Hotel Background" 
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">

    <div class="d-flex flex-column justify-content-center h-100 position-relative text-white">
        <div class="container h-100 d-flex align-items-center">
            <!-- Booking Form Left Side -->
            <div class="p-4 rounded shadow-lg" 
                 style="max-width: 350px; width: 100%; transition: transform 0.3s, box-shadow 0.3s; background: rgba(0,0,0,0.6);">
                <h1 class=" mb-4">Book a room online</h1>
                <form class="d-flex flex-column gap-3">
                    <input type="date" id="arrival" name="arrival" class="form-control" style="height: 40px;" placeholder="Arrival">
                    <input type="date" id="departure" name="departure" class="form-control" style="height: 40px;" placeholder="Departure">
                    <button type="submit" class="btn btn-danger" style="height: 40px; transition: background 0.3s;">Book Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hover Effect CSS -->
<style>
    /* Form hover effect */
    .p-4:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.5);
    }

    /* Button hover effect */
    .btn-danger:hover {
        background-color: #ff4d4d;
        color: #fff;
    }
</style>
@endsection
