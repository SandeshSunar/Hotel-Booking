@extends('admin.layouts.master')

@section('title', 'Guests')

@section('content')
<div class="p-4">
    <div class="mb-4">
        <div>
            <h4 class="fw-bold mb-1">👥 Guest Management</h4>
            <p class="text-muted mb-3">List of all hotel guests.</p>
        </div>
        <div class="mb-3">
            <form action="{{ route('admin.guest.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" style="width: 350px;" placeholder="Search guest by name, email..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary">Search</button>
            </form>
        </div>
        <div class="mb-4">
            <a href="{{ route('admin.guest.create') }}" class="btn btn-success">➕ Add Guest</a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body">
                    <h6 class="card-title">Single Room Bookings</h6>
                    <h2 class="mb-0">{{ $singleBookings }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body">
                    <h6 class="card-title">Double Room Bookings</h6>
                    <h2 class="mb-0">{{ $doubleBookings }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark shadow h-100">
                <div class="card-body">
                    <h6 class="card-title">Family Room Bookings</h6>
                    <h2 class="mb-0">{{ $familyBookings }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-dark shadow h-100">
                <div class="card-body">
                    <h6 class="card-title">Total Occ. (Guests)</h6>
                    <h2 class="mb-0">{{ $totalGuests }} <small class="fs-6">({{ $totalAdults }} A, {{ $totalChildren }} C)</small></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email & Phone</th>
                        <th>Bookings & Occupancy</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guests as $guest)
                        <tr>
                            <td>{{ $guest->id }}</td>
                            <td>{{ $guest->name }}</td>
                            <td>
                                <div>{{ $guest->email }}</div>
                                <small class="text-muted">{{ $guest->phone }}</small>
                            </td>
                            <td>
                                @if($guest->bookings->isNotEmpty())
                                    <ul class="list-unstyled mb-0">
                                    @foreach($guest->bookings as $booking)
                                        <li>
                                            <strong>{{ $booking->roomType->name ?? 'Room' }}</strong>: 
                                            {{ $booking->adults }} Adults, {{ $booking->children }} Children 
                                            <span class="badge bg-secondary">{{ $booking->adults + $booking->children }} Total Guests</span>
                                        </li>
                                    @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">No bookings</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.guest.show', $guest->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.guest.edit', $guest->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.guest.destroy', $guest->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No guests found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
