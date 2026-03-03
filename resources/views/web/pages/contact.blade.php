@extends('web.layouts.master')

@section('title', 'Contact Us')

@section('content')
<div class="bg-dark text-light p-5 mb-4">
    <div class="container py-5">
        <h1 class="display-5 fw-bold">Contact Us</h1>
        <p class="fs-4">📞 +977-9812345678 | ✉️ info@myhotel.com</p>
        <h3 class="mt-4">Find Us Here:</h3>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Contact Form -->
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" name="phone" id="phone" class="form-control" placeholder="Enter your phone number" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea name="message" id="message" rows="5" class="form-control" placeholder="Type your message here..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>

            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <!-- Google Map -->
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.080412493457!2d85.31132281506191!3d27.71724593278859!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb190b3f1d2c1d%3A0x3b1f0c2e024aaa6a!2sKathmandu!5e0!3m2!1sen!2snp!4v1631891726453!5m2!1sen!2snp" 
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</div>
@endsection
