@extends('admin.layouts.master')

@section('title', 'Add Staff')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">➕ Add Staff</h4>

    <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $name->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Image </label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Phone <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $phone->phone ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Email <span class=text-danger>*</span></label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $email->email ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Role <span class=text-danger>*</span></label>
            <input type="text" name="role" class="form-control" value="{{ old('role', $role->role ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Save Staff</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
