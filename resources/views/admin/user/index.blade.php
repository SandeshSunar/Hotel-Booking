@extends('admin.layouts.masters')

@section('content')
<!-- Main Content -->
<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Users Table</h2>
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Create
        </a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->age }}</td>
                <td>
                    <a href="{{ route('admin.user.edit', $user->id) }}">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="border: none; background: none; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class="bi bi-trash text-danger"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection