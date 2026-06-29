<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Forgot Password - MyHotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('web/assets/css/auth.css') }}">
</head>
<body class="auth-page auth-page-simple">
    <div class="auth-wrapper-simple">
        <div class="auth-card">
            <div class="auth-card-header">
                <h2>Forgot Password</h2>
                <p>Enter your admin email to receive a reset link</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success auth-alert">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger auth-alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}" class="auth-form">
                @csrf

                <div class="auth-input-group">
                    <i class="bi bi-envelope input-icon"></i>
                    <label for="adminForgotEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="adminForgotEmail" name="email" value="{{ old('email') }}"
                           placeholder="admin@example.com" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="auth-btn">
                    <i class="bi bi-send"></i> Send Reset Link
                </button>
            </form>

            <p class="auth-switch">
                <a href="{{ route('admin.login') }}" class="auth-link">Back to Admin Login</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
