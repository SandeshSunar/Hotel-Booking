<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MyHotel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('web/assets/css/auth.css') }}">
</head>
<body class="auth-page">
    <div class="auth-wrapper">
        <div class="auth-visual">
            <div class="auth-visual-content">
                <div class="auth-visual-badge">
                    <i class="bi bi-stars"></i> Premium Hotel Experience
                </div>
                <h1>@yield('visual-title', 'Welcome to MyHotel')</h1>
                <p>@yield('visual-text', 'Discover comfort, elegance, and unforgettable stays. Sign in to manage bookings and enjoy exclusive member benefits.')</p>
            </div>
        </div>

        <div class="auth-panel">
            <div class="auth-card">
                <div class="auth-card-header">
                    <div class="auth-icon-wrap">
                        <i class="bi @yield('icon', 'bi-door-open')"></i>
                    </div>
                    <h2>@yield('heading')</h2>
                    <p>@yield('subheading')</p>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
