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
  public function index()
  {
    $user = Auth::user();
    $orders = Order::whereHas('orderItems.product', function ($query) use ($user) {
      $query->where('vendor_id', $user->id);
    })
      ->with('orderItems.product')
      ->latest()
      ->get()
      ->map(function ($order) {
        return [
          'id' => $order->id,
          'user_name' => $order->full_name,
          'user_email' => $order->user->email,
          'order_date' => $order->created_at->format('d M Y'),
          'status' => $order->status,
          'shipping_address' => $order->street_address . ', ' . ($order->city ?? '') . ', ' . $order->postal_code . ', ' . $order->country,
          'phone' => $order->user->phone ?? 'N/A',
        ];
      });

    Log::info('Vendor Orders Retrieved', ['vendor_id' => $user->id, 'order_count' => $orders->count()]);

    return view('vendor.orders', compact('orders'));
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
}