<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with('items')
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Check if order belongs to logged in user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel order (if pending)
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);
            
            // Restore stock
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order cancelled successfully');
        }

        return redirect()->back()
            ->with('error', 'Order cannot be cancelled');
    }

    /**
     * Track order status
     */
    public function track(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.track', compact('order'));
    }
}
