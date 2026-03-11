<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        
        $product = Product::find($productId);
        if (!$product || $product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Product not available'
            ]);
        }
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            if ($product->stock < ($cart[$productId]['quantity'] + $quantity)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock'
                ]);
            }
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image_url,
                'stock' => $product->stock
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'cart_count' => array_sum(array_column($cart, 'quantity')),
            'cart_total' => $this->calculateTotal($cart)
        ]);
    }

    public function update(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $product = Product::find($productId);
            if ($product && $product->stock >= $quantity) {
                $cart[$productId]['quantity'] = $quantity;
                session()->put('cart', $cart);
                
                return response()->json([
                    'success' => true,
                    'item_total' => $cart[$productId]['price'] * $quantity,
                    'cart_total' => $this->calculateTotal($cart)
                ]);
            }
        }
        
        return response()->json(['success' => false]);
    }

    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'cart_count' => array_sum(array_column($cart, 'quantity')),
            'cart_total' => $this->calculateTotal($cart)
        ]);
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }

    public function getCount()
    {
        $cart = session()->get('cart', []);
        return response()->json(['count' => array_sum(array_column($cart, 'quantity'))]);
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}