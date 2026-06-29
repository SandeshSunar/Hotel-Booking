@extends('auth.layout')

@section('title', 'Register - MyHotel')

@section('visual-title', 'Become a valued guest')
@section('visual-text', 'Create your account to unlock faster bookings, personalized offers, and exclusive access to our finest suites.')
@section('icon', 'bi-person-plus')
@section('heading', 'Create Account')
@section('subheading', 'Fill in your details to get started')

@section('content')
    @if ($errors->any() || session('error'))
        <div class="alert alert-danger auth-alert">
            @if (session('error'))
                {{ session('error') }}
            @else
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}" class="auth-form">
        @csrf

        <div class="auth-input-group">
            <i class="bi bi-person input-icon"></i>
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name') }}"
                   placeholder="John Doe" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="auth-input-group">
            <i class="bi bi-envelope input-icon"></i>
            <label for="registerEmail" class="form-label">Email address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="registerEmail" name="email" value="{{ old('email') }}"
                   placeholder="you@example.com" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="auth-input-group">
            <i class="bi bi-telephone input-icon"></i>
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                   id="phone" name="phone" value="{{ old('phone') }}"
                   placeholder="07XXXXXXXX" required>
            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="auth-input-group">
            <i class="bi bi-lock input-icon"></i>
            <label for="registerPassword" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror"
                   id="registerPassword" name="password"
                   placeholder="Minimum 6 characters" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="auth-input-group">
            <i class="bi bi-shield-lock input-icon"></i>
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control"
                   id="password_confirmation" name="password_confirmation"
                   placeholder="Repeat your password" required>
        </div>

        <button type="submit" class="auth-btn">
            <i class="bi bi-person-plus"></i> Create Account
        </button>
    </form>

    <p class="auth-switch">
        Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign in</a>
    </p>
@endsection
