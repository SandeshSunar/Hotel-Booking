@extends('admin.layouts.master')

@section('title', 'Customer Messages')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">💬 Customer Messages</h4>
    <p class="text-muted">Messages submitted from the contact form.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Received At</th>
                            <th>Actions</th>
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
                                <td class="d-flex gap-2">
                                    <a href="{{ route('admin.message.show', $message->id) }}" class="btn btn-sm btn-secondary">View</a>
                                    <a href="{{ route('admin.message.edit', $message->id) }}" class="btn btn-sm btn-primary"> Edit</a>
                                    <form action="{{ route('admin.message.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No messages yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
