@extends('web.layouts.master')

@section('title', 'Gallery')

@section('content')
<style>
    .gallery-heading {
        text-align: center;
        margin-bottom: 2rem;
        font-weight: bold;
    }

    .gallery-img-wrapper {
        overflow: hidden;
        border-radius: 10px;
    }

    .gallery-img-wrapper img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }

    .gallery-img-wrapper img:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .gallery-row {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .gallery-row .col-md-3 {
        margin-bottom: 1.5rem;
    }
</style>

<h1 class="gallery-heading">Our Gallery</h1>

<div class="row gallery-row g-3 justify-content-center">
    @forelse($galleries as $gallery)
        <div class="col-md-3">
            <div class="gallery-img-wrapper">
                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}">
            </div>
        </div>
    @empty
        <p class="text-center">No images found.</p>
    @endforelse
</div>
@endsection
