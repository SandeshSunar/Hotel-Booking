@extends('web.layouts.master')

@section('title', 'My Account')

@section('content')
    @php
        $avatarLetter = strtoupper(mb_substr($user->name ?? 'U', 0, 1));
    @endphp

    <style>
        .profile-page {
            padding: 4.5rem 0;
            background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
        }

        .profile-shell {
            max-width: 1100px;
        }

        .profile-hero {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 1.5rem;
            border-radius: 1.5rem;
            background: #fff;
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
            margin-bottom: 1.5rem;
        }

        .profile-avatar {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d6efd, #20c997);
            color: #fff;
            font-size: 1.6rem;
            font-weight: 800;
            flex: 0 0 auto;
        }

        .profile-name {
            margin: 0;
            font-size: 1.65rem;
            font-weight: 800;
            color: #0f172a;
        }

        .profile-subtitle {
            margin: 0.25rem 0 0;
            color: #64748b;
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            background: rgba(13, 110, 253, 0.08);
            color: #0d6efd;
            font-weight: 700;
            font-size: 0.85rem;
            margin-top: 0.75rem;
        }

        .profile-card {
            height: 100%;
            background: #fff;
            border-radius: 1.25rem;
            padding: 1.25rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(148, 163, 184, 0.16);
        }

        .profile-stat {
            padding: 1rem;
            border-radius: 1rem;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .profile-stat-label {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .profile-stat-value {
            color: #0f172a;
            font-weight: 700;
            margin: 0;
        }

        .profile-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            color: #0f172a;
            padding: 0.95rem 1rem;
            border-radius: 0.95rem;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.12);
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .profile-link:hover {
            background: #eef6ff;
            color: #0d6efd;
        }
    </style>

    <section class="profile-page">
        <div class="container profile-shell">
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="profile-hero">
                <div class="profile-avatar">{{ $avatarLetter }}</div>
                <div>
                    <h1 class="profile-name">{{ $user->name }}</h1>
                    <p class="profile-subtitle">Manage your account, bookings, and saved stays in one place.</p>
                    <div class="profile-badge"><i class="bi bi-stars"></i> Customer Profile</div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="profile-card">
                        <h4 class="fw-bold mb-3">Personal Details</h4>
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="profile-stat">
                                        <div class="profile-stat-label">Full Name</div>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter your full name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="profile-stat">
                                        <div class="profile-stat-label">Email</div>
                                        <input type="email" value="{{ $user->email }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="profile-stat">
                                        <div class="profile-stat-label">Phone Number</div>
                                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="Enter your phone number">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="profile-stat">
                                        <div class="profile-stat-label">Member Level</div>
                                        <p class="profile-stat-value mb-0">Genius Level 1</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <button type="submit" class="btn auth-btn">
                                    <i class="bi bi-check2-circle"></i> Save Changes
                                </button>
                                <a href="{{ route('profile.index') }}"
                                    class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="profile-card mb-4">
                        <h4 class="fw-bold mb-3">Quick Actions</h4>
                        <a class="profile-link" href="{{ route('rooms') }}">
                            <span><i class="bi bi-door-open me-2"></i> Book a Room</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a class="profile-link" href="{{ route('contact') }}">
                            <span><i class="bi bi-headset me-2"></i> Contact Support</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a class="profile-link" href="{{ route('home') }}">
                            <span><i class="bi bi-house me-2"></i> Back to Home</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="profile-card">
                        <h4 class="fw-bold mb-3">Your Menu</h4>
                        <p class="text-muted mb-3">Use the profile dropdown in the navbar to access your account and sign
                            out safely.</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn auth-btn w-100">
                                <i class="bi bi-box-arrow-right"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
