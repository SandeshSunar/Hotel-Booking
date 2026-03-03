@extends('user.layouts.master')

@section('content')

<!-- Main Content -->
<div class="p-4">
    <h2>This is dashboard</h2>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text fs-3 fw-bold">{{ $statistics['totalUsersCount'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Admin</h5>
                    <p class="card-text fs-3 fw-bold">{{ $statistics['totalAdminsCount'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection