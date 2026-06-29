<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Reset Password - MyHotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('web/assets/css/auth.css') }}">
</head>
<body class="auth-page auth-page-simple">
    <div class="auth-wrapper-simple">
        <div class="auth-card">
            <div class="auth-card-header">
                <h2>Reset Password</h2>
                <p>Create a new password for your admin account</p>
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

            <form method="POST" action="{{ route('admin.password.update') }}" class="auth-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="auth-input-group">
                    <i class="bi bi-envelope input-icon"></i>
                    <label for="adminResetEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="adminResetEmail" name="email" value="{{ old('email', request('email')) }}"
                           placeholder="admin@example.com" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="auth-input-group">
                    <i class="bi bi-lock input-icon"></i>
                    <label for="adminNewPassword" class="form-label">New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="adminNewPassword" name="password"
                           placeholder="Minimum 8 characters" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="auth-input-group">
                    <i class="bi bi-shield-lock input-icon"></i>
                    <label for="adminConfirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control"
                           id="adminConfirmPassword" name="password_confirmation"
                           placeholder="Repeat your password" required>
                </div>

                <button type="submit" class="auth-btn">
                    <i class="bi bi-check-circle"></i> Reset Password
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
