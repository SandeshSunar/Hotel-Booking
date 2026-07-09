<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top web-navbar">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <img class="nav-logo" src="{{ asset('images/logo.png') }}" alt="MyHotel Logo" height="70">
        </a>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('rooms') ? 'active' : '' }}"
                        href="{{ route('rooms') }}">Our Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('gallery') ? 'active' : '' }}"
                        href="{{ route('gallery') }}">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('blog') ? 'active' : '' }}"
                        href="{{ route('blog') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">Contact Us</a>
                </li>
                @auth
                    @php
                        $currentUser = auth()->user();
                        $avatarLetter = strtoupper(mb_substr($currentUser->name ?? 'U', 0, 1));
                    @endphp
                    <li class="nav-item dropdown ms-lg-2">
                        <button class="btn nav-user-toggle dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="nav-user-avatar">{{ $avatarLetter }}</span>
                            <span class="nav-user-meta">
                                <span class="nav-user-name">{{ $currentUser->name }}</span>
                                <span class="nav-user-level">Customer Profile</span>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end nav-user-menu shadow border-0">
                            <li class="nav-user-menu-header">
                                <div class="nav-user-avatar nav-user-avatar-large">{{ $avatarLetter }}</div>
                                <div>
                                    <div class="fw-bold">{{ $currentUser->name }}</div>
                                    <div class="text-muted small">{{ $currentUser->email }}</div>
                                </div>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-person"></i>
                                    My Account</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i
                                        class="bi bi-briefcase"></i> Bookings & Trips</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-heart"></i>
                                    Saved</a></li>
                            <li><a class="dropdown-item" href="{{ route('contact') }}"><i class="bi bi-headset"></i>
                                    Support</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="px-2 pb-1">
                                    @csrf
                                    <button type="submit" class="dropdown-item nav-user-logout"><i
                                            class="bi bi-box-arrow-right"></i> Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
                @guest
                    <li class="nav-item me-2">
                        <button type="button" class="btn nav-auth-btn" data-bs-toggle="modal"
                            data-bs-target="#loginModal">Login</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn nav-auth-btn nav-auth-btn-outline" data-bs-toggle="modal"
                            data-bs-target="#registerModal">Register</button>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Login Modal -->
<div class="modal fade auth-modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header position-relative">
                <div class="w-100 text-center">
                    <div class="auth-icon-wrap">
                        <i class="bi bi-door-open"></i>
                    </div>
                    <h5 class="modal-title fw-bold" id="loginModalLabel">Welcome Back</h5>
                    <p class="text-muted small mb-0">Sign in to continue your journey</p>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- @if (!old('name') && ($errors->any() || session('error') || session('success')))
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
                @endif --}}

                <form method="POST" action="{{ route('login.submit') }}" class="auth-form">
                    @csrf

                    <div class="auth-input-group">
                        <i class="bi bi-envelope input-icon"></i>
                        <label for="modalEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="modalEmail" name="email" value="{{ old('email') }}"
                            placeholder="Enter your email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-input-group">
                        <i class="bi bi-lock input-icon"></i>
                        <label for="modalPassword" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="modalPassword" name="password" placeholder="Enter your password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-forgot">
                        <a href="{{ route('password.request') }}" class="auth-link small">Forgot password?</a>
                    </div>

                    <button type="submit" class="auth-btn">
                        <i class="bi bi-box-arrow-in-right"></i> Sign In
                    </button>
                </form>

                <p class="auth-switch">
                    Don't have an account?
                    <button type="button" class="btn btn-link auth-link p-0 align-baseline" data-bs-toggle="modal"
                        data-bs-target="#registerModal" data-bs-dismiss="modal">
                        Create one
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade auth-modal" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header position-relative">
                <div class="w-100 text-center">
                    <div class="auth-icon-wrap">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h5 class="modal-title fw-bold" id="registerModalLabel">Create Account</h5>
                    <p class="text-muted small mb-0">Join us and book your perfect stay</p>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- @if (old('name') && ($errors->any() || session('error')))
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
                @endif --}}

                <form method="POST" action="{{ route('register.submit') }}" class="auth-form">
                    @csrf

                    <div class="auth-input-group">
                        <i class="bi bi-person input-icon"></i>
                        <label for="modalName" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="modalName"
                            name="name" value="{{ old('name') }}" placeholder="John Doe" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-input-group">
                        <i class="bi bi-envelope input-icon"></i>
                        <label for="modalRegisterEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="modalRegisterEmail" name="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-input-group">
                        <i class="bi bi-telephone input-icon"></i>
                        <label for="modalPhone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                            id="modalPhone" name="phone" value="{{ old('phone') }}" placeholder="07XXXXXXXX"
                            required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-input-group">
                        <i class="bi bi-lock input-icon"></i>
                        <label for="modalRegisterPassword" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="modalRegisterPassword" name="password" placeholder="Minimum 6 characters" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-input-group">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <label for="modalPasswordConfirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="modalPasswordConfirmation"
                            name="password_confirmation" placeholder="Repeat your password" required>
                    </div>

                    <button type="submit" class="auth-btn">
                        <i class="bi bi-person-plus"></i> Create Account
                    </button>
                </form>

                <p class="auth-switch">
                    Already have an account?
                    <button type="button" class="btn btn-link auth-link p-0 align-baseline" data-bs-toggle="modal"
                        data-bs-target="#loginModal" data-bs-dismiss="modal">
                        Sign in
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>
