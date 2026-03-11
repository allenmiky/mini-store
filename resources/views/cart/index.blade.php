@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<h1 class="mb-4">Shopping Cart</h1>

@if(empty($cart))
<div class="text-center py-5">
    <h3>Your cart is empty</h3>
    <a href="{{ route('products') }}" class="btn btn-primary mt-3">
        Continue Shopping
    </a>
</div>
@else
<div class="row">
    <div class="col-md-8">
        @foreach($cart as $id => $item)
        <div class="card mb-3" id="cart-item-{{ $id }}">
            <div class="row g-0">
                <div class="col-md-3">
                    <img src="{{ $item['image'] ?? 'https://via.placeholder.com/150' }}" 
                         class="img-fluid rounded-start" 
                         alt="{{ $item['name'] }}"
                         style="height: 150px; object-fit: cover;">
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $item['name'] }}</h5>
                            <button class="btn btn-sm btn-danger remove-item" data-product-id="{{ $id }}">
                                Remove
                            </button>
                        </div>
                        <p class="card-text"><strong>Price:</strong> Rs{{ number_format($item['price'], 2) }}</p>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Quantity:</label>
                                <input type="number" class="form-control quantity-input" 
                                       value="{{ $item['quantity'] }}" 
                                       min="1" 
                                       max="{{ $item['stock'] }}"
                                       data-product-id="{{ $id }}">
                            </div>
                            <div class="col-md-4">
                                <strong>Subtotal:</strong>
                                <span class="item-subtotal">Rs{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cart Summary</h5>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total:</span>
                    <strong class="cart-total">Rs{{ number_format($total, 2) }}</strong>
                </div>
                <a href="{{ route('products') }}" class="btn btn-outline-primary w-100 mb-2">
                    Continue Shopping
                </a>
                <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger w-100" 
                   onclick="return confirm('Clear cart?')">
                    Clear Cart
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    $('.quantity-input').on('change', function() {
        let productId = $(this).data('product-id');
        let quantity = $(this).val();
        
        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    $(`#cart-item-${productId} .item-subtotal`).text('Rs' + response.item_total.toFixed(2));
                    $('.cart-total').text('Rs' + response.cart_total.toFixed(2));
                }
            }
        });
    });
    
    $('.remove-item').on('click', function() {
        let productId = $(this).data('product-id');
        
        if (confirm('Remove item from cart?')) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        $(`#cart-item-${productId}`).fadeOut(300, function() {
                            $(this).remove();
                            $('.cart-total').text('Rs' + response.cart_total.toFixed(2));
                            updateCartCount();
                            if ($('.cart-item').length === 0) {
                                location.reload();
                            }
                        });
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection