@extends('admin.layouts.masters')

@section('content')
<div class="p-4">
    <h2>Edit User</h2>

    <form action="{{ route('admin.user.update',$user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control @error('email') is-invalid @enderror" value="{{ old('name') ?? $user->name }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}
            </div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') ?? $user->email }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input
                type="number" name="age" id="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') ?? $user->age }}">
            @error('age')
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