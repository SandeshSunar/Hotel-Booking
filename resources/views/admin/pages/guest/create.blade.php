@extends('admin.layouts.master')

@section('title', 'Add Guest')

@section('content')
    <div class="p-4">
        <h4 class="fw-bold mb-3">➕ Add Guest</h4>

        <form action="{{ route('admin.guest.store') }}" method="POST">
            @csrf
            <div class="md-3">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $name->name ?? '') }}"
                    required></input>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Email <span class="text-danger">*</span>
                </label>

                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="md-3">
                <label class="form-lavel">Phone <sapan class="text-danger">*</sapan></label>
                <input type="tel" name="phone" class="form-control" value="{{ old('phone', $phone->phone ?? '') }}"
                    required></input>

                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Address <span class="text-danger">*</span>
                </label>

                <input type="text" name="address" class="form-control"
                    value="{{ old('address', $guest->address ?? '') }}" required>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success">
                    Save Guest
                </button>

                <a href="{{ route('admin.guest.index') }}" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </form>
    </div>
@endsection
