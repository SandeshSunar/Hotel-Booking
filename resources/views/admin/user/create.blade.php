@extends('admin.layouts.masters')

@section('content')
<div class="p-4">
    <h2>Create User</h2>

    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control @error('email') is-invalid @enderror">
            @error('name')
            <div class="invalid-feedback">{{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input
                type="number" name="age" id="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}">
            @error('age')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password"
                    class="password form-control @error('password') is-invalid @enderror"
                    value="{{ old('password') }}">
                <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                    <i class="bi password-toggle bi-eye"></i>
                </span>
            </div>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-lg"></i> Save
        </button>
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('body').on('click', '.password-toggle', function() {
            if ($(this).hasClass('bi-eye')) {
                $(this).removeClass('bi-eye');
                $(this).addClass('bi-eye-slash');
                $('.password').attr('type', 'text');
            } else { // bi-eye xaina
                $(this).removeClass('bi-eye-slash');
                $(this).addClass('bi-eye');
                $('.password').attr('type', 'password');
            }
        });
    });
</script>
@endpush