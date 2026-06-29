@extends('auth.layout')

@section('title', 'Login - MyHotel')

@section('visual-title', 'Your escape starts here')
@section('visual-text', 'Access your reservations, explore premium rooms, and enjoy a seamless booking experience tailored just for you.')
@section('icon', 'bi-door-open')
@section('heading', 'Welcome Back')
@section('subheading', 'Sign in to your account')

@section('content')
    @if ($errors->any() || session('error') || session('success'))
        <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }} auth-alert">
            @if (session('success'))
                {{ session('success') }}
            @elseif (session('error'))
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

    <form method="POST" action="{{ route('login.submit') }}" class="auth-form">
        @csrf

        <div class="auth-input-group">
            <i class="bi bi-envelope input-icon"></i>
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email" name="email" value="{{ old('email') }}"
                   placeholder="you@example.com" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="auth-input-group">
            <i class="bi bi-lock input-icon"></i>
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror"
                   id="password" name="password"
                   placeholder="Enter your password" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="auth-forgot">
            <a href="{{ route('password.request') }}" class="auth-link small">Forgot password?</a>
        </div>

        <button type="submit" class="auth-btn">
            <i class="bi bi-box-arrow-in-right"></i> Sign In
        </button>
    </form>

    <p class="auth-switch">
        Don't have an account? <a href="{{ route('register') }}" class="auth-link">Create one</a>
    </p>
@endsection
