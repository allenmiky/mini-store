@extends('layouts.app')

@section('title', $category->name . ' Products')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">{{ $category->name }}</h1>
        @if($category->description)
            <p class="lead">{{ $category->description }}</p>
        @endif
    </div>
</div>

<div class="row">
    @forelse($products as $product)
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300' }}" 
                 class="card-img-top" 
                 alt="{{ $product->name }}"
                 style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text text-success fw-bold">Rs{{ number_format($product->price, 2) }}</p>
                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary w-100">
                    View Details
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            No products found in this category.
        </div>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>
@endsection