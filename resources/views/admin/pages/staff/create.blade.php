@extends('admin.layouts.master')

@section('title', 'Add Staff')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">➕ Add Staff</h4>

    <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <input type="text" name="role" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save Staff</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
