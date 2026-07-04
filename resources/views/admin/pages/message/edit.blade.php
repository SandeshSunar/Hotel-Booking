@extends('admin.layouts.master')

@section('title', 'Edit Message')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">✏️ Edit Message</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3 text-muted">
        Received on {{ $message->created_at->format('d M Y, h:i A') }}
    </div>

    <form action="{{ route('admin.message.update', $message->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $message->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $message->phone) }}" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" rows="6" class="form-control" required>{{ old('message', $message->message) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Message</button>
        <a href="{{ route('admin.message.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
