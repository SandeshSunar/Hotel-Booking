@extends('admin.layouts.master')

@section('title', 'Add Guest')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">➕ Add Guest</h4>

    <form action="{{ route('admin.guest.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save Guest</button>
        <a href="{{ route('admin.guest.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
