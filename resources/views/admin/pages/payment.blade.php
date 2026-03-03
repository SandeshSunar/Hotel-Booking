@extends('admin.layouts.master')

@section('title', 'Payments')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">💳 Payments Management</h4>
    <p class="text-muted">View all payment transactions.</p>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Booking ID</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->booking_id }}</td>
                            <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                            <td>{{ ucfirst($payment->method) }}</td>
                            <td><span class="badge bg-success">{{ ucfirst($payment->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No payments found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
