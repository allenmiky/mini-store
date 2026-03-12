@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Order #{{ $order->order_number }}</h4>
            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
        <div>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>Back to Orders
            </a>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-1"></i>Shop More
            </a>
        </div>
    </div>

    <!-- Order Status -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <small class="text-muted">Order Status</small>
                    <h5>
                        @php
                            $statusClass = [
                                'pending' => 'warning',
                                'processing' => 'info',
                                'shipped' => 'primary',
                                'delivered' => 'success',
                                'cancelled' => 'danger'
                            ][$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusClass }} fs-6">
                            {{ ucfirst($order->status) }}
                        </span>
                    </h5>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Payment Status</small>
                    <h5>
                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} fs-6">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </h5>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Payment Method</small>
                    <h5>{{ ucfirst($order->payment_method) }}</h5>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Shipping Method</small>
                    <h5>{{ ucfirst($order->shipping_method) }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Items -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $item->product_name }}</h6>
                                                <small class="text-muted">SKU: {{ $item->product_sku ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-end fw-bold">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary & Shipping -->
        <div class="col-md-4">
            <!-- Order Summary -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal:</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping:</span>
                        <span>${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tax:</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    @if($order->discount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span class="text-muted">Discount:</span>
                        <span>-${{ number_format($order->discount, 2) }}</span>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total:</span>
                        <span class="text-primary">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Shipping Address</h5>
                </div>
                <div class="card-body">
                    <address class="mb-0">
                        <strong>{{ $order->customer_first_name }} {{ $order->customer_last_name }}</strong><br>
                        {{ $order->shipping_address }}<br>
                        @if($order->shipping_apartment)
                            {{ $order->shipping_apartment }}<br>
                        @endif
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                        {{ $order->shipping_country }}<br>
                        <abbr title="Phone">P:</abbr> {{ $order->customer_phone }}<br>
                        <abbr title="Email">E:</abbr> {{ $order->customer_email }}
                    </address>
                </div>
            </div>

            <!-- Cancel Button (if pending) -->
            @if($order->status == 'pending')
            <div class="mt-3">
                <form action="{{ route('orders.cancel', $order) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to cancel this order?')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-times me-2"></i>Cancel Order
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection