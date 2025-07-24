<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Bid;
use App\Models\Notification;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Events\OrderStatusUpdated;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Order::whereHas('orderItems.product', function ($q) use ($user) {
            $q->where('vendor_id', $user->id);
        })->with('orderItems.product');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

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

        $orders = $query->latest()->paginate(10);
        $orderCounts = $this->getOrderCounts($user->id);

        $bidQuery = Bid::where('vendor_id', $user->id)->with('product', 'user');

        if ($request->has('bid_status') && $request->bid_status) {
            $bidQuery->where('status', $request->bid_status);
        }

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

        $bids = $bidQuery->latest()->paginate(10);
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
            'phone_number' => $order->phone_number,
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

            Notification::create([
                'user_id' => $order->user_id,
                'type' => 'order_status',
                'message' => 'Your order with ' . $order->vendor . ' has been updated to ' . $validated['status'] . '.',
                'data' => json_encode([
                    'order_id' => $order->id,
                    'status' => $validated['status'],
                ]),
            ]);

            if ($validated['status'] === 'Completed') {
                event(new OrderStatusUpdated($order, $user->id));
            }

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
                Bid::where('product_id', $bid->product_id)
                    ->where('user_id', $bid->user_id)
                    ->where('id', '!=', $bid->id)
                    ->where('status', 'Accepted')
                    ->update(['status' => 'Rejected']);
            }

            $bid->update(['status' => $validated['status']]);

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

    public function submitRating(Request $request, $orderId)
    {
        try {
            $user = Auth::user();
            $order = Order::where('id', $orderId)
                ->where('user_id', $user->id)
                ->where('status', 'Completed')
                ->with('orderItems.product')
                ->firstOrFail();

            $validated = $request->validate([
                'ratings' => 'required|array',
                'ratings.*.product_id' => 'required|exists:products,id',
                'ratings.*.rating' => 'required|integer|min:1|max:5',
            ]);

            foreach ($validated['ratings'] as $ratingData) {
                $product = $order->orderItems->where('product_id', $ratingData['product_id'])->first()->product;

                $existingRating = Rating::where([
                    'order_id' => $order->id,
                    'product_id' => $ratingData['product_id'],
                    'user_id' => $user->id,
                ])->first();

                if ($existingRating) {
                    return response()->json([
                        'success' => false,
                        'message' => "You have already rated the product: {$product->name} for this order.",
                    ], 400);
                }

                Rating::create([
                    'order_id' => $order->id,
                    'product_id' => $ratingData['product_id'],
                    'user_id' => $user->id,
                    'rating' => $ratingData['rating'],
                ]);

                $product->updateAverageRating();

                Log::info('Rating submitted', [
                    'order_id' => $order->id,
                    'product_id' => $ratingData['product_id'],
                    'user_id' => $user->id,
                    'rating' => $ratingData['rating'],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ratings submitted successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Rating Submission Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit ratings: ' . $e->getMessage(),
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

    public function orderHistory(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login.form')->withErrors(['login' => 'Please log in to view your order history.']);
            }

            $orders = Order::where('user_id', $user->id)
                ->with(['orderItems.product', 'ratings'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('status');

            return view('procurement.order_history', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Order History Error: ' . $e->getMessage(), [
                'user_id' => Auth::id() ?? 'guest',
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('procurement.dashboardproc')->withErrors([
                'error' => 'Failed to load order history: ' . $e->getMessage()
            ]);
        }
    }
}