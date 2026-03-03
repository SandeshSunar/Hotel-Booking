@extends('web.layouts.master')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Forgot Password</h3>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label>Email address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Send OTP</button>
        </form>

        <p class="text-center mt-3">
            <a href="{{ route('login') }}">Back to Login</a>
        </p>
    </div>
</div>
@endsection
