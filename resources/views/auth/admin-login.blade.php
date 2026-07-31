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



            <form method="POST" action="{{ route('admin.login.submit') }}" class="auth-form" id="login-form">
                @csrf

                <div class="auth-input-group">
                    <i class="bi bi-envelope input-icon"></i>
                    <label for="adminEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="adminEmail" name="email" value="{{ old('email') }}"
                           placeholder="Enter email" {{ session('login_locked') ? 'disabled' : '' }} required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="auth-input-group">
                    <i class="bi bi-lock input-icon"></i>
                    <label for="adminPassword" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="adminPassword" name="password"
                           placeholder="Enter your password" {{ session('login_locked') ? 'disabled' : '' }} required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="auth-forgot">
                    <a href="{{ route('admin.password.request') }}" class="auth-link small">Forgot password?</a>
                </div>

                <button type="submit" class="auth-btn" id="login-btn" {{ session('login_locked') ? 'disabled' : '' }}>
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>
            </form>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100; margin-top: 1rem;">
        @if(session('success'))
            <div id="successToast" class="toast align-items-center text-white bg-success border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div id="errorToast" class="toast align-items-center text-white bg-danger border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        @if(session('login_locked'))
                            <div>Too many failed attempts! Please wait <span id="toastCountdown" class="fw-bold">{{ session('login_locked_seconds', 60) }}</span> second(s) before trying again.</div>
                        @else
                            <div>{{ session('error') }}</div>
                        @endif
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if($errors->any() && !session('error'))
            <div id="validationToast" class="toast align-items-center text-white bg-danger border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex flex-column gap-1">
                        <div class="d-flex align-items-center gap-2 fw-bold">
                            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                            <span>Please fix the following errors:</span>
                        </div>
                        <ul class="mb-0 ps-3 mt-1 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successToastEl = document.getElementById('successToast');
            if (successToastEl) {
                var successToast = new bootstrap.Toast(successToastEl, { delay: 6000 });
                successToast.show();
            }
            var errorToastEl = document.getElementById('errorToast');
            if (errorToastEl) {
                var delayMs = {{ session('login_locked') ? (session('login_locked_seconds', 60) * 1000 + 1000) : 6000 }};
                var errorToast = new bootstrap.Toast(errorToastEl, { delay: delayMs });
                errorToast.show();
            }
            var validationToastEl = document.getElementById('validationToast');
            if (validationToastEl) {
                var validationToast = new bootstrap.Toast(validationToastEl, { delay: 8000 });
                validationToast.show();
            }
        });

        @if (session('login_locked'))
        (function () {
            var seconds = {{ session('login_locked_seconds', 60) }};
            var timer = setInterval(function () {
                seconds--;
                if (seconds <= 0) {
                    clearInterval(timer);
                    window.location.reload();
                } else {
                    var tC = document.getElementById('toastCountdown');
                    if(tC) tC.textContent = seconds;
                }
            }, 1000);
        })();
        @endif
    </script>
</body>
</html>
