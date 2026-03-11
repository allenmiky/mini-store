@extends('layouts.app')

@section('title', 'All Products')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5>Filters</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('products') }}" method="GET">
                    <div class="mb-3">
                        <label>Search</label>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label>Sort By</label>
                        <select name="sort" class="form-control">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    <a href="{{ route('products') }}" class="btn btn-secondary w-100 mt-2">Clear Filters</a>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="row">
            @forelse($products as $product)
            <div class="col-md-4 mb-4">
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
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No products found.
                </div>
            </div>
            @endforelse
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection