<?php
// app/Http/Controllers/StoreController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')
            ->withCount('products')
            ->having('products_count', '>', 0)
            ->take(6)
            ->get();
        
        $latestProducts = Product::with('category')
            ->available()
            ->latest()
            ->take(8)
            ->get();
        
        return view('store.index', compact('categories', 'latestProducts'));
    }

    public function products(Request $request)
    {
        $query = Product::with('category')->available();
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $sort = $request->sort ?? 'newest';
        
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }
        
        $products = $query->paginate(12);
        $categories = Category::where('status', 'active')->get();
        
        return view('store.products', compact('products', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();
        
        $products = Product::where('category_id', $category->id)
            ->available()
            ->paginate(12);
        
        return view('store.category', compact('category', 'products'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->available()
            ->take(4)
            ->get();
        
        return view('store.product', compact('product', 'relatedProducts'));
    }
}