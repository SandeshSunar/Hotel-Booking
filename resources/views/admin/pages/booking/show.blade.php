@extends('admin.layouts.master')

@section('title', 'Booking #' . $booking->id)

@section('content')
<div class="p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0">📋 Booking #{{ $booking->id }}</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.booking.edit', $booking->id) }}" class="btn btn-primary btn-sm">✏️ Edit</a>
            <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary btn-sm">← Back to Bookings</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Booking Status Card --}}
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                    <div>
                        <span class="text-muted small">Status</span>
                        <div>
                            @if($booking->status === 'confirmed')
                                <span class="badge bg-success fs-6 px-3 py-2">✅ Confirmed</span>
                            @elseif($booking->status === 'completed')
                                <span class="badge bg-info text-dark fs-6 px-3 py-2">🏁 Completed</span>
                            @elseif($booking->status === 'cancelled')
                                <span class="badge bg-danger fs-6 px-3 py-2">❌ Cancelled</span>
                            @else
                                <span class="badge bg-warning text-dark fs-6 px-3 py-2">⏳ Pending</span>
                            @endif
                        </div>
                    </div>
                    <div class="vr d-none d-md-block"></div>
                    <div>
                        <span class="text-muted small">Total Price</span>
                        <div class="fw-bold fs-5 text-success">Rs. {{ number_format($booking->total_price, 2) }}</div>
                    </div>
                    <div class="vr d-none d-md-block"></div>
                    <div>
                        <span class="text-muted small">Booked On</span>
                        <div class="fw-semibold">{{ $booking->created_at->format('d M, Y h:i A') }}</div>
                    </div>
                    <div class="ms-auto d-flex gap-2 flex-wrap">
                        @if($booking->status === 'pending')
                            <a href="{{ route('admin.booking.approve', $booking->id) }}" class="btn btn-success btn-sm">✅ Confirm</a>
                            <a href="{{ route('admin.booking.reject', $booking->id) }}" class="btn btn-warning btn-sm">❌ Cancel</a>
                        @endif
                        @if($booking->status === 'confirmed')
                            <a href="{{ route('admin.booking.complete', $booking->id) }}" class="btn btn-info btn-sm text-white">🏁 Mark Complete</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Guest Details --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white fw-semibold">
                    👤 Guest Information
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width:40%">Name</td>
                            <td class="fw-semibold">{{ $booking->guest_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td><a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Phone</td>
                            <td>{{ $booking->phone }}</td>
                        </tr>
                        @if($booking->guest && $booking->guest->address)
                        <tr>
                            <td class="text-muted">Address</td>
                            <td>{{ $booking->guest->address }}</td>
                        </tr>
                        @endif
                        @if($booking->user)
                        <tr>
                            <td class="text-muted">Registered As</td>
                            <td>{{ $booking->user->name }} <span class="badge bg-secondary">User</span></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        {{-- Booking Details --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white fw-semibold">
                    🛏️ Booking Details
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width:40%">Room Type</td>
                            <td class="fw-semibold">{{ $booking->roomType->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Rooms</td>
                            <td>{{ $booking->rooms_count }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Check-In</td>
                            <td>{{ $booking->check_in->format('D, d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Check-Out</td>
                            <td>{{ $booking->check_out->format('D, d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Duration</td>
                            <td>{{ $booking->check_in->diffInDays($booking->check_out) }} Night(s)</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Guests</td>
                            <td>{{ $booking->adults }} Adult(s), {{ $booking->children }} Child(ren)</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Payment Details --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white fw-semibold">
                    💳 Payment Information
                </div>
                <div class="card-body">
                    @if($booking->payment)
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted" style="width:40%">Amount</td>
                                <td class="fw-semibold text-success">Rs. {{ number_format($booking->payment->amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Method</td>
                                <td class="text-capitalize">{{ $booking->payment->payment_method }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Payment Status</td>
                                <td>
                                    @if($booking->payment->status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($booking->payment->status === 'refunded')
                                        <span class="badge bg-secondary">Refunded</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Payment Date</td>
                                <td>{{ $booking->payment->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </table>
                    @else
                        <p class="text-muted mb-0">No payment record found.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Special Requests --}}
        @if($booking->special_requests)
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white fw-semibold">
                    📝 Special Requests
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $booking->special_requests }}</p>
                </div>
            </div>
        </div>
        @endif

    </div>{{-- end row --}}

    {{-- Danger Zone --}}
    <div class="mt-4">
        <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Are you sure you want to delete this booking?')" class="btn btn-outline-danger btn-sm">
                🗑️ Delete Booking
            </button>
        </form>
    </div>

</div>
@endsection
