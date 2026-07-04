@extends('admin.layouts.master')

@section('title', 'Add Room Type')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">➕ Add Room Type</h4>

    @include('admin.pages.room-types._form', [
        'action' => route('admin.room-types.store'),
        'method' => 'POST',
        'roomType' => null,
        'facilities' => old('facilities', ['']),
    ])
</div>
@endsection
