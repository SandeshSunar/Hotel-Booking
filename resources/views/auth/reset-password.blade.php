@extends('web.layouts.master')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5" style="min-height: 70vh;">
    <div class="auth-card" style="max-width: 440px; width: 100%;">
        <div class="auth-card-header">
            <div class="auth-icon-wrap">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h2>Reset Password</h2>
            <p>Create a new password for your account</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger auth-alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="auth-input-group">
                <i class="bi bi-envelope input-icon"></i>
                <label for="resetEmail" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="resetEmail" name="email" value="{{ old('email', request('email')) }}"
                       placeholder="you@example.com" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="auth-input-group">
                <i class="bi bi-lock input-icon"></i>
                <label for="newPassword" class="form-label">New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="newPassword" name="password"
                       placeholder="Minimum 8 characters" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="auth-input-group">
                <i class="bi bi-shield-lock input-icon"></i>
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control"
                       id="confirmPassword" name="password_confirmation"
                       placeholder="Repeat your password" required>
            </div>

            <button type="submit" class="auth-btn">
                <i class="bi bi-check-circle"></i> Reset Password
            </button>
        </form>

        <p class="auth-switch">
            <a href="{{ route('home') }}" class="auth-link">Back to Home</a>
        </p>
    </div>
</div>
@endsection
