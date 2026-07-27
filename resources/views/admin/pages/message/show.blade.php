@extends('admin.layouts.master')

@section('title', 'Message from ' . $message->name)

@section('content')
<div class="p-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0">💬 Message Details</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.message.edit', $message->id) }}" class="btn btn-primary btn-sm">✏️ Edit</a>
            <a href="{{ route('admin.message.index') }}" class="btn btn-secondary btn-sm">← Back to Messages</a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Sender Details --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white fw-semibold">
                    👤 Sender Information
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width: 35%">Name</td>
                            <td class="fw-semibold">{{ $message->name }}</td>
                        </tr>
                        @if($message->email)
                        <tr>
                            <td class="text-muted">Email</td>
                            <td><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-muted">Phone</td>
                            <td>{{ $message->phone }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Received</td>
                            <td>{{ $message->created_at->format('D, d M Y') }}<br>
                                <span class="text-muted small">{{ $message->created_at->format('h:i A') }} &middot; {{ $message->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Message Body --}}
        <div class="col-md-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white fw-semibold">
                    📝 Message
                </div>
                <div class="card-body">
                    <p class="mb-0" style="white-space: pre-line; line-height: 1.8;">{{ $message->message }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Danger Zone --}}
    <div class="mt-4">
        <form action="{{ route('admin.message.destroy', $message->id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Are you sure you want to delete this message?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">🗑️ Delete Message</button>
        </form>
    </div>

</div>
@endsection
