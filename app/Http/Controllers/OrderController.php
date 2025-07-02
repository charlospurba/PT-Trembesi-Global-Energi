<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Bid;
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

        // Apply status filter for orders
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Apply search filter for orders
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('full_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('street_address', 'like', '%' . $searchTerm . '%')
                    ->orWhere('city', 'like', '%' . $searchTerm . '%')
                    ->orWhere('postal_code', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('email', 'like', '%' . $searchTerm . '%')
                            ->orWhere('phone', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        // Get filtered orders with pagination
        $orders = $query->latest()->paginate(10);

        // Get order counts for each status
        $orderCounts = $this->getOrderCounts($user->id);

        // Base query for vendor bids
        $bidQuery = Bid::where('vendor_id', $user->id)->with('product', 'user');

        // Apply status filter for bids
        if ($request->has('bid_status') && $request->bid_status) {
            $bidQuery->where('status', $request->bid_status);
        }

        // Apply search filter for bids
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $bidQuery->where(function ($q) use ($searchTerm) {
                $q->whereHas('product', function ($productQuery) use ($searchTerm) {
                    $productQuery->where('name', 'like', '%' . $searchTerm . '%');
                })->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                    $userQuery->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        // Get filtered bids with pagination
        $bids = $bidQuery->latest()->paginate(10);

        // Get bid counts for each status
        $bidCounts = $this->getBidCounts($user->id);

        Log::info('Vendor Orders and Bids Retrieved', [
            'vendor_id' => $user->id,
            'order_count' => $orders->count(),
            'bid_count' => $bids->count(),
            'status_filter' => $request->status,
            'bid_status_filter' => $request->bid_status,
            'search_filter' => $request->search
        ]);

        return view('vendor.orders', compact('orders', 'orderCounts', 'bids', 'bidCounts'));
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

    public function updateBidStatus(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $bid = Bid::where('id', $id)
                ->where('vendor_id', $user->id)
                ->firstOrFail();

            $validated = $request->validate([
                'status' => 'required|in:Pending,Accepted,Rejected',
            ]);

            if ($validated['status'] === 'Accepted') {
                // Reject other accepted bids for the same product and user
                Bid::where('product_id', $bid->product_id)
                    ->where('user_id', $bid->user_id)
                    ->where('id', '!=', $bid->id)
                    ->where('status', 'Accepted')
                    ->update(['status' => 'Rejected']);
            }

            $bid->update(['status' => $validated['status']]);

            // Notify the user who submitted the bid
            Notification::create([
                'user_id' => $bid->user_id,
                'type' => 'bid_status',
                'message' => 'Your bid for ' . $bid->product->name . ' has been ' . $validated['status'] . '.',
                'data' => json_encode([
                    'bid_id' => $bid->id,
                    'status' => $validated['status'],
                ]),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bid status updated successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Bid Status Update Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update bid status: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getOrderCounts($vendorId)
    {
        $baseCondition = function ($query) use ($vendorId) {
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

    private function getBidCounts($vendorId)
    {
        return [
            'all' => Bid::where('vendor_id', $vendorId)->count(),
            'pending' => Bid::where('vendor_id', $vendorId)->where('status', 'Pending')->count(),
            'accepted' => Bid::where('vendor_id', $vendorId)->where('status', 'Accepted')->count(),
            'rejected' => Bid::where('vendor_id', $vendorId)->where('status', 'Rejected')->count(),
        ];
    }
}