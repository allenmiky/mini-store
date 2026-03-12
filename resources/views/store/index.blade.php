@extends('layouts.app')

@section('title', 'Home - FlownexStore')

@section('content')
<div class="bg-light p-5 rounded-3 mb-4">
    <div class="container py-4">
        <h1 class="display-4">Welcome to Flownex Store! 🛍️</h1>
        <p class="lead">Your one-stop shop for amazing products at best prices.</p>
        <hr class="my-4">
        <p>Shop from hundreds of products with fast delivery.</p>
        <a class="btn btn-primary btn-lg" href="{{ route('products') }}" role="button">
            Start Shopping
        </a>
    </div>
</div>

@if(isset($categories) && $categories->count() > 0)
<div class="row mt-5">
    <h2 class="text-center mb-4">Shop by Category</h2>
    @foreach($categories as $category)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">{{ $category->name }}</h5>
                <p class="card-text text-muted">{{ $category->products_count ?? 0 }} Products</p>
                <a href="{{ route('category.show', $category->slug) }}" class="btn btn-outline-primary">
                    View Category
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@if(isset($latestProducts) && $latestProducts->count() > 0)
<div class="row mt-5">
    <h2 class="text-center mb-4">Latest Products</h2>
    @foreach($latestProducts as $product)
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300' }}" 
                 class="card-img-top" 
                 alt="{{ $product->name }}"
                 style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text text-success fw-bold">Rs{{ number_format($product->price, 2) }}</p>
                <p class="card-text">
                    <small class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</small>
                </p>
                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary w-100">
                    View Details
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection