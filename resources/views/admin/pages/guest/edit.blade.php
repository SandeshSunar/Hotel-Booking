@extends('admin.layouts.master')

@section('title', 'Edit Guest')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">✏️ Edit Guest</h4>

    <form action="{{ route('admin.guest.update', $guest->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $guest->name }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $guest->email }}" required>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $guest->phone }}" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="{{ $guest->address }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Guest</button>
        <a href="{{ route('admin.guest.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
