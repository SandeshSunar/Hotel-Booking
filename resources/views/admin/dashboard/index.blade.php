@extends('admin.layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<style>
/* Custom Dashboard Styles */
.dashboard-wrapper {
    background-color: #f4f6f9;
    min-height: calc(100vh - 60px); 
}
.dashboard-card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.dashboard-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}
.dashboard-card .card-body {
    padding: 1.5rem 1.5rem;
    position: relative;
    z-index: 2;
}
.dash-icon {
    font-size: 3.5rem;
    position: absolute;
    right: 15px;
    bottom: 10px;
    opacity: 0.2;
    z-index: 1;
    transition: transform 0.3s ease;
}
.dashboard-card:hover .dash-icon {
    transform: scale(1.1);
}
.bg-grad-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-grad-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.bg-grad-warning { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
.bg-grad-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.bg-grad-danger { background: linear-gradient(135deg, #ff0844 0%, #ffb199 100%); }

.section-title {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 25px;
    font-size: 1.5rem;
    position: relative;
    padding-left: 15px;
}
.section-title::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 80%;
    width: 5px;
    background: #667eea;
    border-radius: 5px;
}

.modern-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.03);
    overflow: hidden;
}
.modern-card .card-header {
    background-color: #fff;
    border-bottom: 1px solid rgba(230, 230, 230, 0.7);
    padding: 18px 25px;
    font-size: 1.15rem;
    color: #34495e;
}
.table-wrapper {
    padding: 0;
}
.modern-table > :not(caption) > * > * {
    padding: 1.2rem 1.5rem;
    vertical-align: middle;
    border-bottom-color: #f1f5f9;
}
.modern-table thead th {
    background-color: #f8fafc;
    color: #64748b;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    border-bottom: none;
}
.modern-table tbody tr {
    transition: background-color 0.2s;
}
.modern-table tbody tr:hover {
    background-color: #f8fafc;
}
.status-badge {
    padding: 0.5em 1em;
    border-radius: 50rem;
    font-weight: 500;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}
.avatar-img {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    border: 2px solid #fff;
}
</style>

<div class="p-4 dashboard-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark">
            <i class="bi bi-person-workspace text-primary me-2"></i>Welcome back, {{ Auth::user()->name }} 👋
        </h4>
        <span class="text-muted"><i class="bi bi-calendar3 me-1"></i> {{ date('l, F j, Y') }}</span>
    </div>

    <!-- ================= TOP STATS CARDS ================= -->
    <div class="row g-4 mb-5">
        <div class="col-xl col-md-6 col-sm-12 text-white">
            <div class="card dashboard-card bg-grad-primary shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2">Active Bookings</h6>
                    <h2 class="mb-0 fw-bold display-5">{{ $statistics['totalBookings'] }}</h2>
                    <i class="bi bi-bookmark-check dash-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-6 col-sm-12 text-white">
            <div class="card dashboard-card bg-grad-success shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2">Total Rooms</h6>
                    <h2 class="mb-0 fw-bold display-5">{{ $statistics['totalRooms'] }}</h2>
                    <i class="bi bi-door-open dash-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-6 col-sm-12 text-white">
            <div class="card dashboard-card bg-grad-warning shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2">Available Rooms</h6>
                    <h2 class="mb-0 fw-bold display-5">{{ $statistics['availableRooms'] }}</h2>
                    <i class="bi bi-key dash-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-6 col-sm-12 text-white">
            <div class="card dashboard-card bg-grad-info shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2">Total Guests</h6>
                    <h2 class="mb-0 fw-bold display-5">{{ $statistics['totalGuests'] }}</h2>
                    <i class="bi bi-people dash-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-6 col-sm-12 text-white">
            <div class="card dashboard-card bg-grad-danger shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold mb-2">Total Staff</h6>
                    <h2 class="mb-0 fw-bold display-5">{{ $statistics['totalStaff'] }}</h2>
                    <i class="bi bi-person-badge dash-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MANAGEMENT SECTIONS ================= -->
    <div class="row g-4 mb-5">
        <!-- ===== Recent Bookings ===== -->
        <div class="col-lg-7">
            <div class="card modern-card h-100">
                <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clock-history me-2 text-primary"></i>Recent Bookings</span>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
                </div>
                <div class="card-body table-wrapper table-responsive">
                    <table class="table modern-table mb-0">
                        <thead>
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
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $booking->guest->name ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-door-closed text-secondary me-2"></i>
                                            <span>{{ $booking->room->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted"><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</div>
                                    </td>
                                    <td>
                                        @if(strtolower($booking->status) == 'completed')
                                            <span class="badge status-badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">{{ ucfirst($booking->status) }}</span>
                                        @elseif(strtolower($booking->status) == 'cancelled')
                                            <span class="badge status-badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">{{ ucfirst($booking->status) }}</span>
                                        @elseif(strtolower($booking->status) == 'confirmed')
                                            <span class="badge status-badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ ucfirst($booking->status) }}</span>
                                        @else
                                            <span class="badge status-badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4"><i class="bi bi-inbox fs-2 d-block mb-2 text-secondary opacity-50"></i>No active bookings yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===== Calendar ===== -->
        <div class="col-lg-5">
            <div class="card modern-card h-100">
                <div class="card-header fw-bold">
                    <i class="bi bi-calendar-check me-2 text-primary"></i>Schedule Calendar
                </div>
                <div class="card-body p-0">
                    <iframe src="https://calendar.google.com/calendar/embed?height=350&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FKathmandu&showTitle=0&showNav=1&showDate=1&showPrint=0&showTabs=1&showCalendars=0&showTz=0"
                            style="border-width:0" 
                            width="100%" height="350" frameborder="0" scrolling="no">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- ===== Guest Management ===== -->
        <div class="col-lg-6">
            <div class="card modern-card h-100">
                <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-person-lines-fill me-2 text-primary"></i>Recent Guests</span>
                </div>
                <div class="card-body table-wrapper table-responsive">
                    <table class="table modern-table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentGuests as $guest)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-img bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3 fw-bold">
                                                {{ strtoupper(substr($guest->name, 0, 1)) }}
                                            </div>
                                            <span class="fw-semibold text-dark">{{ $guest->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted small mb-1"><i class="bi bi-envelope me-1"></i> {{ $guest->email }}</div>
                                        <div class="text-muted small"><i class="bi bi-telephone me-1"></i> {{ $guest->phone }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-muted py-4"><i class="bi bi-people d-block fs-2 mb-2 text-secondary opacity-50"></i>No guests found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===== Staff Management ===== -->
        <div class="col-lg-6">
            <div class="card modern-card h-100">
                <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-person-badge-fill me-2 text-primary"></i>Recent Staff Members</span>
                </div>
                <div class="card-body table-wrapper table-responsive">
                    <table class="table modern-table mb-0">
                        <thead>
                            <tr>
                                <th>Staff Member</th>
                                <th>Role</th>
                                <th>Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStaff as $staff)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(!empty($staff->image))
                                                <img src="{{ asset('storage/staff/' . basename($staff->image)) }}" 
                                                     alt="{{ $staff->name }}" 
                                                     class="avatar-img me-3">
                                            @else
                                                <div class="avatar-img bg-secondary bg-opacity-10 text-secondary d-flex align-items-center justify-content-center me-3 fw-bold">
                                                    {{ strtoupper(substr($staff->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <span class="fw-semibold text-dark">{{ $staff->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border px-2 py-1">{{ ucfirst($staff->role) }}</span>
                                    </td>
                                    <td>
                                        <div class="text-muted small"><i class="bi bi-telephone me-1"></i> {{ $staff->phone }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4"><i class="bi bi-person-x d-block fs-2 mb-2 text-secondary opacity-50"></i>No staff found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
