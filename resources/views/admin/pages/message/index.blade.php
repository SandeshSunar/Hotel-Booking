@extends('admin.layouts.master')

@section('title', 'Customer Messages')

@section('content')
<div class="container mt-4">
    <h2>Customer Messages</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Received At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
                <tr>
                    <td>{{ $message->id }}</td>
                    <td>{{ $message->name }}</td>
                    <td>{{ $message->phone }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($message->message, 50) }}</td>
                    <td>{{ $message->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No messages yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
