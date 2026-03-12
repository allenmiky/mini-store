@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Orders</h2>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
        </a>
    </div>

    @if($orders->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
        <h4>No orders yet</h4>
        <p class="text-muted">Looks like you haven't placed any orders.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">
            Start Shopping
        </a>
    </div>
    @else
    <div class="row">
        @foreach($orders as $order)
        <div class="col-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <small class="text-muted">Order #</small>
                            <h6 class="mb-0">{{ $order->order_number }}</h6>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Date</small>
                            <p class="mb-0">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Total</small>
                            <p class="mb-0 fw-bold">${{ number_format($order->total, 2) }}</p>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Status</small>
                            <p class="mb-0">
                                @php
                                    $statusClass = [
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger'
                                    ][$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="{{ route('orders.show', $order) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection