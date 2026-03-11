<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_categories' => Category::count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'total_users' => User::count(),
            'recent_products' => Product::with('category')->latest()->take(5)->get(),
            'recent_categories' => Category::latest()->take(5)->get()
        ];
        
        return view('admin.dashboard', compact('data'));
    }
}