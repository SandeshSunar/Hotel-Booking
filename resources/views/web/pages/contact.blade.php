@extends('web.layouts.master')

@section('title', 'Contact Us')

@section('content')
<section class="contact-hero">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="contact-badge"><i class="bi bi-headset"></i> Contact MyHotel</span>
                <h1 class="contact-title">Let’s plan your comfortable stay</h1>
                <p class="contact-subtitle">
                    Have questions about rooms, pricing, or special requests? Our team is here to help you quickly.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="contact-quick-grid">
                    <div class="contact-quick-item">
                        <i class="bi bi-telephone-fill"></i>
                        <div>
                            <small>Call us</small>
                            <p>+977-9812345678</p>
                        </div>
                    </div>
                    <div class="contact-quick-item">
                        <i class="bi bi-envelope-fill"></i>
                        <div>
                            <small>Email</small>
                            <p>info@myhotel.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-main py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="contact-form-card">
                    <h3 class="contact-card-title">Send Us a Message</h3>
                    <p class="contact-card-subtitle">We usually reply within a few hours.</p>
                    <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter your phone number" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea name="message" id="message" rows="5" class="form-control" placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn contact-submit-btn">Send Message</button>
            </form>
                </div>

                @if(session('success'))
                <div class="alert alert-success mt-3 contact-alert">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger mt-3 contact-alert">
                    {{ session('error') }}
                </div>
                @endif
            </div>

            <div class="col-lg-6">
                <div class="contact-map-card">
                    <h3 class="contact-card-title">Find Us Here</h3>
                    <p class="contact-card-subtitle">Visit us at our central location.</p>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.080412493457!2d85.31132281506191!3d27.71724593278859!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb190b3f1d2c1d%3A0x3b1f0c2e024aaa6a!2sKathmandu!5e0!3m2!1sen!2snp!4v1631891726453!5m2!1sen!2snp"
                        width="100%"
                        height="350"
                        class="contact-map"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                    <div class="contact-address">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>City Center, Main Street, Kathmandu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
