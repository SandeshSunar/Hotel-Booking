@extends('admin.layouts.master')

@section('title', 'Staff Details')

@section('content')
<div class="p-4">
    <div class="d-flex align-items-center mb-4 gap-2">
        <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
        <h4 class="fw-bold mb-0">🧑‍💼 Staff Details</h4>
    </div>

    <div class="row g-4">
        {{-- Profile Card --}}
        <div class="col-md-4">
            <div class="card shadow text-center h-100">
                <div class="card-header bg-dark text-white fw-semibold text-start">
                    Profile
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                    @if($staff->image)
                        <img src="{{ asset('storage/' . $staff->image) }}"
                             alt="{{ $staff->name }}"
                             class="rounded-circle mb-3 shadow"
                             width="120" height="120"
                             style="object-fit: cover; border: 4px solid #dee2e6;">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mb-3 shadow"
                             style="width:120px;height:120px;font-size:2.5rem;color:#fff;">
                            {{ strtoupper(substr($staff->name, 0, 1)) }}
                        </div>
                    @endif
                    <h5 class="fw-bold mb-1">{{ $staff->name }}</h5>
                    <span class="badge bg-primary px-3 py-2 fs-6">{{ ucfirst($staff->role) }}</span>
                </div>
                <div class="card-footer d-flex gap-2">
                    <a href="{{ route('admin.staff.edit', $staff->id) }}" class="btn btn-primary btn-sm w-100">✏️ Edit Staff</a>
                </div>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white fw-semibold">
                    Contact & General Information
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3 text-muted">Full Name</dt>
                        <dd class="col-sm-9">{{ $staff->name }}</dd>

                        <dt class="col-sm-3 text-muted">Email</dt>
                        <dd class="col-sm-9">
                            <a href="mailto:{{ $staff->email }}">{{ $staff->email }}</a>
                        </dd>

                        <dt class="col-sm-3 text-muted">Phone</dt>
                        <dd class="col-sm-9">
                            <a href="tel:{{ $staff->phone }}">{{ $staff->phone }}</a>
                        </dd>

                        <dt class="col-sm-3 text-muted">Role</dt>
                        <dd class="col-sm-9">{{ ucfirst($staff->role) }}</dd>

                        <dt class="col-sm-3 text-muted">Joined</dt>
                        <dd class="col-sm-9">{{ $staff->created_at->format('d M Y') }}</dd>

                        <dt class="col-sm-3 text-muted">Last Updated</dt>
                        <dd class="col-sm-9">{{ $staff->updated_at->format('d M Y, h:i A') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
