@extends('admin.layouts.master')

@section('title', 'Edit Staff')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">✏️ Edit Staff</h4>

    <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ $staff->name }}" required>
        </div>

        <div class="mb-3">
            <label>Image</label><br>
            @if($staff->image)
                <img src="{{ asset('storage/' . $staff->image) }}" width="100" class="rounded mb-2">
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Phone <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control" value="{{ $staff->phone }}" required>
        </div>

        <div class="mb-3">
            <label>Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" value="{{ $staff->email }}" required>
        </div>

        <div class="mb-3">
            <label>Role <span class="text-danger">*</span></label>
            <input type="text" name="role" class="form-control" value="{{ $staff->role }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Staff</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
