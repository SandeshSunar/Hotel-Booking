<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <img class="nav-logo" src="{{ asset('/images/logo.png') }}" alt="MyHotel Logo" height="70">
        </a>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('rooms') ? 'active' : '' }}" href="{{ route('rooms') }}">Our Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('blog') ? 'active' : '' }}" href="{{ route('blog') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
                </li>
                <li class="nav-item me-2">
                    <a class="btn btn-success {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-success {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
