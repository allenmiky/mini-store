@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="container py-5">
    <!-- Success Header -->
    <div class="text-center mb-5">
        <div class="mb-4">
            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                <i class="fas fa-check fa-3x"></i>
            </div>
        </div>
        <h1 class="display-5 fw-bold text-success mb-3">Thank You for Your Order!</h1>
        <p class="lead text-muted">Your order has been placed successfully.</p>
    </div>

    <!-- Order Details Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-receipt text-primary me-2"></i>
                        Order Details
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Order Info -->
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted d-block mb-1">Order Number</small>
                                <strong class="h6">{{ $order->order_number }}</strong>
                                <br>
                                <small class="text-muted">Placed on {{ $order->created_at->format('F j, Y') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted d-block mb-1">Order Status</small>
                                <span class="badge bg-warning text-dark px-3 py-2">{{ ucfirst($order->status) }}</span>
                                <br>
                                <small class="text-muted">Payment: 
                                    <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <h6 class="fw-bold mb-3">Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
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
                                            @if($item->product && $item->product->image_url)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" 
                                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-box text-secondary"></i>
                                                </div>
                                            @endif
                                            <div class="ms-3">
                                                <span class="fw-bold">{{ $item->product_name }}</span>
                                                @if($item->options)
                                                    <small class="text-muted d-block">
                                                        @foreach(json_decode($item->options, true) ?? [] as $key => $value)
                                                            {{ ucfirst($key) }}: {{ $value }}
                                                        @endforeach
                                                    </small>
                                                @endif
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

                    <!-- Order Summary -->
                    <div class="row justify-content-end mt-4">
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-3">Order Summary</h6>
                                
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
                                
                                <hr class="my-3">
                                
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total:</span>
                                    <span class="text-primary h5 mb-0">${{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping & Payment Info -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-truck text-primary me-2"></i>
                                Shipping Information
                            </h6>
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
                            <hr>
                            <div>
                                <small class="text-muted">Shipping Method:</small>
                                <span class="badge bg-info text-dark ms-2">{{ ucfirst($order->shipping_method) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-credit-card text-primary me-2"></i>
                                Payment Information
                            </h6>
                            
                            <div class="d-flex align-items-center mb-3">
                                @if($order->payment_method == 'card')
                                    <i class="fas fa-credit-card fa-2x text-secondary me-3"></i>
                                    <div>
                                        <span class="fw-bold">Credit/Debit Card</span><br>
                                        <small class="text-muted">
                                            @if($order->transaction_id)
                                                Transaction: {{ substr($order->transaction_id, -8) }}
                                            @endif
                                        </small>
                                    </div>
                                    
                                @elseif($order->payment_method == 'paypal')
                                    <i class="fab fa-paypal fa-2x text-primary me-3"></i>
                                    <div>
                                        <span class="fw-bold">PayPal</span><br>
                                        <small class="text-muted">
                                            @if($order->transaction_id)
                                                Transaction: {{ substr($order->transaction_id, -8) }}
                                            @endif
                                        </small>
                                    </div>
                                    
                                @elseif($order->payment_method == 'cod')
                                    <i class="fas fa-money-bill-wave fa-2x text-success me-3"></i>
                                    <div>
                                        <span class="fw-bold">Cash on Delivery</span><br>
                                        <small class="text-muted">Pay when you receive</small>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Payment Status:</span>
                                    <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Order Date:</span>
                                    <span>{{ $order->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-5">
                <div>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        <i class="fas fa-home me-2"></i>Continue Shopping
                    </a>
                    
                    @auth
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-history me-2"></i>View Orders
                    </a>
                    @endauth
                </div>
                
                <button onclick="window.print()" class="btn btn-light">
                    <i class="fas fa-print me-2"></i>Print Receipt
                </button>
            </div>

            <!-- Email Confirmation Message -->
            <div class="alert alert-success mt-4 mb-0">
                <i class="fas fa-envelope me-2"></i>
                A confirmation email has been sent to <strong>{{ $order->customer_email }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
@push('styles')
<style>
@media print {
    .navbar, .footer, .btn, .alert {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
}
</style>
@endpush
@endsection