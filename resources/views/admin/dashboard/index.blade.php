@extends('admin.layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-4">🏨 Welcome, {{ Auth::user()->name }}</h4>

    <!-- ================= TOP STATS CARDS ================= -->
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body text-center">
                    <h6>Total Bookings</h6>
                    <h3>{{ $statistics['totalBookings'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body text-center">
                    <h6>Total Rooms</h6>
                    <h3>{{ $statistics['totalRooms'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body text-center">
                    <h6>Available Rooms</h6>
                    <h3>{{ $statistics['availableRooms'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MANAGEMENT SECTIONS ================= -->
    <div class="row mt-5">
        <!-- ===== Recent Bookings ===== -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header fw-bold bg-light">Recent Bookings</div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th>Guest</th>
                                <th>Room</th>
                                <th>Check-In</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                                <tr>
                                    <td>{{ $booking->guest->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->room->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($booking->status) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">No bookings yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===== Calendar ===== -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header fw-bold bg-light">Calendar</div>
                <div class="card-body text-center">
                    <iframe src="https://calendar.google.com/calendar/embed?height=300&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FKathmandu"
                            style="border:solid 1px #777; border-radius: 6px;" 
                            width="100%" height="300" frameborder="0" scrolling="no">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- ===== Guest Management ===== -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header fw-bold bg-light">Guest Management</div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentGuests as $guest)
                                <tr>
                                    <td>{{ $guest->name }}</td>
                                    <td>{{ $guest->email }}</td>
                                    <td>{{ $guest->phone }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">No guests found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===== Staff Management ===== -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header fw-bold bg-light">Staff Management</div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Role</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStaff as $staff)
                                <tr>
                                    <td>{{ $staff->name }}</td>

                                    <!-- ✅ FIXED IMAGE PATH -->
                                    <td>
                                        @if(!empty($staff->image))
                                            <img src="{{ asset('storage/staff/' . basename($staff->image)) }}" 
                                                 alt="{{ $staff->name }}" 
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>

                                    <td>{{ ucfirst($staff->role) }}</td>
                                    <td>{{ $staff->phone }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">No staff found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
