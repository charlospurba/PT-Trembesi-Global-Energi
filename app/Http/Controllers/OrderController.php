<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Base query for vendor orders
        $query = Order::whereHas('orderItems.product', function ($q) use ($user) {
            $q->where('vendor_id', $user->id);
        })->with('orderItems.product');
        
        // Apply status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('full_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('id', 'like', '%' . $searchTerm . '%')
                  ->orWhere('street_address', 'like', '%' . $searchTerm . '%')
                  ->orWhere('city', 'like', '%' . $searchTerm . '%')
                  ->orWhere('postal_code', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('email', 'like', '%' . $searchTerm . '%')
                               ->orWhere('phone', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        // Get filtered orders
        $orders = $query->latest()->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'user_name' => $order->full_name,
                'user_email' => $order->user->email,
                'order_date' => $order->created_at->format('d M Y'),
                'status' => $order->status,
                'shipping_address' => $order->street_address . ', ' . ($order->city ?? '') . ', ' . $order->postal_code . ', ' . $order->country,
                'phone' => $order->user->phone ?? 'N/A',
                'total_amount' => $order->total_price,
            ];
        });
        
        // Get order counts for each status
        $orderCounts = $this->getOrderCounts($user->id);
        
        Log::info('Vendor Orders Retrieved', [
            'vendor_id' => $user->id, 
            'order_count' => $orders->count(),
            'status_filter' => $request->status,
            'search_filter' => $request->search
        ]);
        
        return view('vendor.orders', compact('orders', 'orderCounts'));
    }
    
    public function show($id)
    {
        $user = Auth::user();
        $order = Order::where('id', $id)
            ->whereHas('orderItems.product', function ($query) use ($user) {
                $query->where('vendor_id', $user->id);
            })
            ->with('orderItems.product')
            ->firstOrFail();

        $orderDetails = [
            'id' => $order->id,
            'user_name' => $order->full_name,
            'user_email' => $order->user->email,
            'order_date' => $order->created_at->format('d M Y'),
            'status' => $order->status,
            'shipping_address' => $order->street_address . ', ' . ($order->city ?? '') . ', ' . $order->postal_code . ', ' . $order->country,
            'phone' => $order->user->phone ?? 'N/A',
            'items' => $order->orderItems->map(function ($item) {
                return [
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'variant' => $item->variant,
                    'total' => $item->price * $item->quantity,
                ];
            })->toArray(),
            'total_price' => $order->total_price,
        ];

        return view('vendor.order_detail', compact('orderDetails'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $order = Order::where('id', $id)
                ->whereHas('orderItems.product', function ($query) use ($user) {
                    $query->where('vendor_id', $user->id);
                })
                ->firstOrFail();

            $validated = $request->validate([
                'status' => 'required|in:Awaiting Shipment,Shipped,Completed,Cancelled',
            ]);

            $order->update(['status' => $validated['status']]);

            // Notify the procurement user
            Notification::create([
                'user_id' => $order->user_id,
                'type' => 'order_status',
                'message' => 'Your order with ' . $order->vendor . ' has been updated to ' . $validated['status'] . '.',
                'data' => json_encode([
                    'order_id' => $order->id,
                    'status' => $validated['status'],
                ]),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Order Status Update Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function getOrderCounts($vendorId)
    {
        // Method 1: Create new query for each count (Recommended)
        $baseCondition = function($query) use ($vendorId) {
            $query->whereHas('orderItems.product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            });
        };
        
        return [
            'all' => Order::where($baseCondition)->count(),
            'awaiting_shipment' => Order::where($baseCondition)->where('status', 'Awaiting Shipment')->count(),
            'shipped' => Order::where($baseCondition)->where('status', 'Shipped')->count(),
            'completed' => Order::where($baseCondition)->where('status', 'Completed')->count(),
            'cancelled' => Order::where($baseCondition)->where('status', 'Cancelled')->count(),
        ];
    }
}