@extends('admin.layouts.master')

@section('title', 'Staff')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">🧑‍💼 Staff Management</h4>
    <p class="text-muted">Manage all hotel staff members.</p>

    <a href="{{ route('admin.staff.create') }}" class="btn btn-success mb-3">➕ Add Staff</a>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffs as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->name }}</td>
                        <td>
                            @if($member->image)
                                <img src="{{ asset('storage/' . $member->image) }}" 
                                alt="Staff Image" 
                                width="60" 
                                height="60" 
                                class="rounded-circle">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ ucfirst($member->role) }}</td>
                        <td>{{ $member->email }}</td>
                         <td>{{$member->phone}}

                        <td>
                            <a href="{{ route('admin.staff.edit', $member->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.staff.destroy', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">No staff found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
