@extends('admin.layouts.master')

@section('title', 'Guest Details')

@section('content')
<div class="p-4">
    <div class="d-flex align-items-center mb-4 gap-2">
        <a href="{{ route('admin.guest.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
        <h4 class="fw-bold mb-0">👤 Guest Details</h4>
    </div>

    <div class="row g-4">
        {{-- Guest Profile Card --}}
        <div class="col-md-4">
            <div class="card shadow h-100">
                <div class="card-header bg-dark text-white fw-semibold">
                    Profile Information
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted">Name</dt>
                        <dd class="col-sm-8">{{ $guest->name }}</dd>

                        <dt class="col-sm-4 text-muted">Email</dt>
                        <dd class="col-sm-8">{{ $guest->email }}</dd>

                        <dt class="col-sm-4 text-muted">Phone</dt>
                        <dd class="col-sm-8">{{ $guest->phone }}</dd>

                        <dt class="col-sm-4 text-muted">Address</dt>
                        <dd class="col-sm-8">{{ $guest->address ?? '—' }}</dd>

                        <dt class="col-sm-4 text-muted">Registered</dt>
                        <dd class="col-sm-8">{{ $guest->created_at->format('d M Y') }}</dd>
                    </dl>
                </div>
                <div class="card-footer d-flex gap-2">
                    <a href="{{ route('admin.guest.edit', $guest->id) }}" class="btn btn-primary btn-sm w-100">✏️ Edit Guest</a>
                </div>
            </div>
        </div>

        {{-- Bookings Card --}}
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white fw-semibold d-flex justify-content-between align-items-center">
                    <span>🛏️ Booking History</span>
                    <span class="badge bg-info text-dark">{{ $guest->bookings->count() }} booking(s)</span>
                </div>
                <div class="card-body p-0">
                    @if($guest->bookings->isNotEmpty())
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th>#</th>
                                    <th>Room Type</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Guests</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guest->bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->roomType->name ?? '—' }}</td>
                                        <td>{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('d M Y') : '—' }}</td>
                                        <td>{{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('d M Y') : '—' }}</td>
                                        <td>
                                            {{ $booking->adults }} Adult(s),
                                            {{ $booking->children }} Child(ren)
                                        </td>
                                        <td>
                                            @php $status = $booking->status ?? 'pending'; @endphp
                                            <span class="badge 
                                                @if($status === 'confirmed') bg-success
                                                @elseif($status === 'cancelled') bg-danger
                                                @else bg-warning text-dark
                                                @endif">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center text-muted py-5">
                            <p class="mb-0">No bookings found for this guest.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
