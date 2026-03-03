@extends('admin.layouts.master')

@section('title', 'Guests')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">👥 Guest Management</h4>
    <p class="text-muted">List of all hotel guests.</p>

    <a href="{{ route('admin.guest.create') }}" class="btn btn-success mb-3">➕ Add Guest</a>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guests as $guest)
                        <tr>
                            <td>{{ $guest->id }}</td>
                            <td>{{ $guest->name }}</td>
                            <td>{{ $guest->email }}</td>
                            <td>{{ $guest->phone }}</td>
                            <td>
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
