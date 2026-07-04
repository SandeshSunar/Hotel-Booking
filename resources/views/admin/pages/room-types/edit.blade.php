@extends('admin.layouts.master')

@section('title', 'Edit Room Type')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">✏️ Edit Room Type</h4>

    @include('admin.pages.room-types._form', [
        'action' => route('admin.room-types.update', $roomType),
        'method' => 'PUT',
        'roomType' => $roomType,
        'facilities' => old('facilities', $roomType->facilities->pluck('name')->toArray() ?: ['']),
    ])
</div>
@endsection
