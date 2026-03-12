<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        // Get cart from session
        $cart = session()->get('cart', []);
        
        // Check if cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add items before checkout.');
        }

        // Calculate totals - YAHAN PROBLEM THA
        $totals = $this->calculateTotals($cart);
        
        // Debug - check totals (ab comment kar do)
        // dd($totals); 

        return view('checkout.index', compact('cart', 'totals'));
    }

    /**
     * Calculate totals - YEH FUNCTION THEEK KARO
     */
    private function calculateTotals($cart)
    {
        $subtotal = 0;
        
        // Loop through cart items
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // Shipping cost
        $shipping = 5.99;
        if ($subtotal > 100) {
            $shipping = 0; // Free shipping
        }
        
        // Tax (10%)
        $tax = $subtotal * 0.10;
        
        // Discount from session
        $discount = session()->get('coupon_discount', 0);
        
        // Total
        $total = $subtotal + $shipping + $tax - $discount;
        
        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'discount' => $discount,
            'total' => $total
        ];
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'shipping_method' => 'required|in:standard,express,nextday',
            'payment_method' => 'required|in:card,paypal,cod',
        ]);

        // Get cart from session
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // Shipping cost based on method
        $shippingCost = $this->getShippingCost($request->shipping_method, $subtotal);
        $tax = $subtotal * 0.10;
        $discount = session()->get('coupon_discount', 0);
        $total = $subtotal + $shippingCost + $tax - $discount;

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
                'user_id' => Auth::id(),
                'customer_first_name' => $request->first_name,
                'customer_last_name' => $request->last_name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_apartment' => $request->address2,
                'shipping_city' => $request->city,
                'shipping_state' => $request->state,
                'shipping_zip' => $request->zip,
                'shipping_country' => $request->country,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'discount' => $discount,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => $request->payment_method == 'cod' ? 'pending' : 'paid'
            ]);

            // Create order items
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);

                // Update stock
                Product::where('id', $id)->decrement('stock', $item['quantity']);
            }

            DB::commit();

            // Clear cart and coupon
            session()->forget('cart');
            session()->forget('coupon_discount');
            session()->forget('coupon_code');
            session()->put('last_order_id', $order->id);

            return redirect()->route('checkout.success')
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Something went wrong! Please try again.')
                ->withInput();
        }
    }

    /**
     * Get shipping cost
     */
    private function getShippingCost($method, $subtotal)
    {
        if ($subtotal > 100) {
            return 0; // Free shipping
        }

        $rates = [
            'standard' => 5.99,
            'express' => 12.99,
            'nextday' => 19.99
        ];

        return $rates[$method] ?? 5.99;
    }

    /**
     * Apply coupon
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon' => 'required|string'
        ]);

        // Mock coupons
        $coupons = [
            'SAVE10' => 10,
            'SAVE20' => 20,
            'WELCOME' => 15,
            'SAVE5' => 5
        ];

        $coupon = strtoupper($request->coupon);

        if (isset($coupons[$coupon])) {
            $cart = session()->get('cart', []);
            
            // Calculate subtotal
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            $discountPercent = $coupons[$coupon];
            $discountAmount = ($subtotal * $discountPercent) / 100;
            
            session()->put('coupon_discount', $discountAmount);
            session()->put('coupon_code', $coupon);

            return response()->json([
                'success' => true,
                'message' => "Coupon applied! You saved $" . number_format($discountAmount, 2),
                'discount' => $discountAmount
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid coupon code'
        ]);
    }

    /**
     * Success page
     */
    public function success()
    {
        $orderId = session()->get('last_order_id');
        
        if (!$orderId) {
            return redirect()->route('home');
        }

        $order = Order::with('items')->find($orderId);
        
        if (!$order) {
            return redirect()->route('home');
        }
        
        return view('checkout.success', compact('order'));
    }
}
