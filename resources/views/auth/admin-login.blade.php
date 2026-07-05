<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - MyHotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('web/assets/css/auth.css') }}">
</head>
<body class="auth-page auth-page-simple">
    <div class="auth-wrapper-simple">
        <div class="auth-card">
            <div class="auth-card-header">
                <h2>Admin Login</h2>
                <p>Sign in to access the dashboard</p>
            </div>

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

            @if (session('success'))
                <div class="alert alert-success auth-alert">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="auth-form">
                @csrf

                <div class="auth-input-group">
                    <i class="bi bi-envelope input-icon"></i>
                    <label for="adminEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="adminEmail" name="email" value="{{ old('email') }}"
                           placeholder="Enter email" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="auth-input-group">
                    <i class="bi bi-lock input-icon"></i>
                    <label for="adminPassword" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="adminPassword" name="password"
                           placeholder="Enter your password" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="auth-forgot">
                    <a href="{{ route('admin.password.request') }}" class="auth-link small">Forgot password?</a>
                </div>

                <button type="submit" class="auth-btn">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
