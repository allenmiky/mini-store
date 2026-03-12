@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/600' }}" 
                 class="card-img-top" 
                 alt="{{ $product->name }}"
                 style="height: 400px; object-fit: contain;">
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h1 class="mb-3">{{ $product->name }}</h1>
                
                <p class="text-muted mb-2">
                    Category: 
                    <a href="{{ route('category.show', $product->category->slug) }}">
                        {{ $product->category->name }}
                    </a>
                </p>
                
                <h2 class="text-success mb-3">Rs{{ number_format($product->price, 2) }}</h2>
                
                <div class="mb-3">
                    <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }} fs-6 p-2">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                    
                    @if($product->stock > 0)
                        <span class="ms-3 text-muted">{{ $product->stock }} units available</span>
                    @endif
                </div>
                
                @if($product->stock > 0)
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="number" 
                               id="quantity" 
                               class="form-control form-control-lg" 
                               value="1" 
                               min="1" 
                               max="{{ $product->stock }}">
                    </div>
                    <div class="col-md-8">
                        <button class="btn btn-success btn-lg w-100" 
                                id="add-to-cart" 
                                data-product-id="{{ $product->id }}">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
                @else
                    <button class="btn btn-secondary btn-lg w-100" disabled>
                        <i class="fas fa-times-circle"></i> Out of Stock
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Description -->

                <div class="mb-4 mt-79">
                    <h5>Description:</h5>
                    <p class="text-muted">{{ $product->description ?? 'No description available.' }}</p>
                </div>

@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<div class="row mt-5">
    <h3 class="mb-4">Related Products</h3>
    @foreach($relatedProducts as $related)
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ $related->image_url ?? 'https://via.placeholder.com/300' }}" 
                 class="card-img-top" 
                 alt="{{ $related->name }}"
                 style="height: 150px; object-fit: cover;">
            <div class="card-body">
                <h6 class="card-title">{{ $related->name }}</h6>
                <p class="text-success fw-bold">Rs{{ number_format($related->price, 2) }}</p>
                <a href="{{ route('product.show', $related->slug) }}" 
                   class="btn btn-sm btn-outline-primary w-100">
                    View Details
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@push('scripts')
<script>
    $('#add-to-cart').click(function() {
        let productId = $(this).data('product-id');
        let quantity = $('#quantity').val();
        
        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    alert('✅ Product added to cart successfully!');
                    updateCartCount();
                } else {
                    alert('❌ ' + response.message);
                }
            },
            error: function() {
                alert('❌ Error adding to cart. Please try again.');
            }
        });
    });
</script>
@endpush
@endsection