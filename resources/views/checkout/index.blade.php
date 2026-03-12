@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-4">Checkout</h4>

                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <!-- Contact Info -->
                        <h5 class="mb-3">Contact Information</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">First Name *</label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                                       value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name *</label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                                       value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone *</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <h5 class="mb-3">Shipping Address</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label">Address Line 1 *</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                                       value="{{ old('address') }}" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address Line 2</label>
                                <input type="text" name="address2" class="form-control" value="{{ old('address2') }}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">City *</label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city') }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State *</label>
                                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" 
                                       value="{{ old('state') }}" required>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">ZIP *</label>
                                <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" 
                                       value="{{ old('zip') }}" required>
                                @error('zip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Country *</label>
                                <select name="country" class="form-select @error('country') is-invalid @enderror" required>
                                    <option value="">Select Country</option>
                                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="PK" {{ old('country') == 'PK' ? 'selected' : '' }}>Pakistan</option>
                                    <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Shipping Method -->
                        <h5 class="mb-3">Shipping Method</h5>
                        <div class="mb-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="shipping_method" id="standard" value="standard" checked>
                                <label class="form-check-label w-100" for="standard">
                                    <div class="d-flex justify-content-between">
                                        <span>Standard Shipping (5-7 days)</span>
                                        <span class="fw-bold">$5.99</span>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="shipping_method" id="express" value="express">
                                <label class="form-check-label w-100" for="express">
                                    <div class="d-flex justify-content-between">
                                        <span>Express Shipping (2-3 days)</span>
                                        <span class="fw-bold">$12.99</span>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="shipping_method" id="nextday" value="nextday">
                                <label class="form-check-label w-100" for="nextday">
                                    <div class="d-flex justify-content-between">
                                        <span>Next Day Delivery</span>
                                        <span class="fw-bold">$19.99</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <h5 class="mb-3">Payment Method</h5>
                        <div class="mb-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="card" value="card" checked>
                                <label class="form-check-label" for="card">Credit/Debit Card</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                <label class="form-check-label" for="paypal">PayPal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod">
                                <label class="form-check-label" for="cod">Cash on Delivery</label>
                            </div>
                        </div>

                        <!-- Card Details (shown when card selected) -->
                        <div id="cardDetails" class="mb-4 p-3 bg-light rounded" style="display: none;">
                            <h6 class="mb-3">Card Details</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="text" name="card_expiry" class="form-control" placeholder="MM/YY">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">CVV</label>
                                    <input type="text" name="card_cvv" class="form-control" placeholder="123">
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="mb-4">
                            <label class="form-label">Order Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Special instructions">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-lock me-2"></i>Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="mb-4">Order Summary</h5>
                    
                    @php $cart = session()->get('cart', []); @endphp
                    
                    @if(!empty($cart))
                        @foreach($cart as $id => $item)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <span>{{ $item['name'] }} x{{ $item['quantity'] }}</span>
                            </div>
                            <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>
                        @endforeach
                        <hr>
                    @endif

                    @php
                        $subtotal = $totals['subtotal'] ?? 0;
                        $shipping = $totals['shipping'] ?? 5.99;
                        $tax = $totals['tax'] ?? 0;
                        $discount = $totals['discount'] ?? 0;
                        $total = $totals['total'] ?? 0;
                    @endphp

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span>${{ number_format($shipping, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax (10%)</span>
                        <span>${{ number_format($tax, 2) }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Discount</span>
                        <span>-${{ number_format($discount, 2) }}</span>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong class="text-primary">${{ number_format($total, 2) }}</strong>
                    </div>

                    <!-- Coupon -->
                    <div class="mt-3">
                        <label class="form-label">Coupon Code</label>
                        <div class="input-group">
                            <input type="text" id="coupon" class="form-control" placeholder="Enter coupon">
                            <button class="btn btn-outline-primary" type="button" onclick="applyCoupon()">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle card details
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('cardDetails').style.display = 
                this.value === 'card' ? 'block' : 'none';
        });
    });

    // Apply coupon
    function applyCoupon() {
        let coupon = document.getElementById('coupon').value;
        if (!coupon) {
            alert('Please enter coupon code');
            return;
        }
        
        fetch('{{ route("checkout.apply-coupon") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ coupon: coupon })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message || 'Invalid coupon');
            }
        });
    }
</script>
@endpush