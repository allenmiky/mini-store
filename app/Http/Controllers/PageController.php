<?php
// app/Http/Controllers/PageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Home page show karega
    public function home()
    {
        $storeName = "Mini Store";
        $categories = ['Electronics', 'Clothing', 'Books'];
        
        // View ko data bhejna
        return view('home', compact('storeName', 'categories'));
    }
    
    // About page
    public function about()
    {
        return view('about');
    }
}