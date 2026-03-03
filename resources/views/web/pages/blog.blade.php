@extends('web.layouts.master')

@section('title', 'Blog')

@section('content')
<style>
    /* 🌅 Background & overall styling */
    body {
        background: url('{{ asset('images/blog_bg.jpg') }}') center center/cover no-repeat fixed;
        color: #333;
    }

    .blog-section {
        background-color: rgba(178, 232, 247, 0.9);
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-top: 60px;
    }

    .blog-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .blog-header h1 {
        font-size: 2.8rem;
        font-weight: bold;
        color: #040608ff;
    }

    .blog-header p {
        font-size: 1.2rem;
        color: #141313ff;
        margin-top: 10px;
    }

    .blog-card {
        background: #ffffffff;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .blog-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .blog-content {
        padding: 20px;
    }

    .blog-content h3 {
        font-size: 1.5rem;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .blog-content p {
        color: #666;
        font-size: 1rem;
        margin-bottom: 0;
    }

    hr {
        border-top: 2px solid #ddd;
        margin: 40px 0;
    }
</style>

<div class="container blog-section">
    <div class="blog-header">
        <h1>✨ Our Blog ✨</h1>
        <p>Explore stories, travel tips, and delightful moments from our hotel experience.</p>
    </div>

    <div class="row">
        <!-- Blog Post 1 -->
        <div class="col-md-6 mb-4">
            <div class="blog-card">
                <img src="{{ asset('images/blog1.jpg') }}" alt="Best Time to Visit" class="img-fluid">
                <div class="blog-content">
                    <h3>Best Time to Visit Our City</h3>
                    <p>Discover the most enchanting seasons to enjoy your stay and make unforgettable memories.</p>
                </div>
            </div>
        </div>

        <!-- Blog Post 2 -->
        <div class="col-md-6 mb-4">
            <div class="blog-card">
                <img src="{{ asset('images/blog2.jpg') }}" alt="Top 5 Things to Do" class="img-fluid">
                <div class="blog-content">
                    <h3>Top 5 Things to Do Nearby</h3>
                    <p>From scenic views to cultural landmarks — explore everything just steps away from our hotel.</p>
                </div>
            </div>
        </div>

        <!-- Blog Post 3 -->
        <div class="col-md-6 mb-4">
            <div class="blog-card">
                <img src="{{ asset('images/blog3.jpg') }}" alt="Gourmet Dining" class="img-fluid">
                <div class="blog-content">
                    <h3>Gourmet Dining Experiences</h3>
                    <p>Indulge your senses in a world of flavor — crafted by our world-class chefs.</p>
                </div>
            </div>
        </div>

        <!-- Blog Post 4 -->
        <div class="col-md-6 mb-4">
            <div class="blog-card">
                <img src="{{ asset('images/blog4.jpg') }}" alt="Wellness and Spa" class="img-fluid">
                <div class="blog-content">
                    <h3>Wellness and Spa Services</h3>
                    <p>Relax, refresh, and rejuvenate — because you deserve to feel your best every day.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
