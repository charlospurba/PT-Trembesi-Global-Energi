<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseRequestController extends Controller
{
  /**
   * Display a listing of purchase requests.
   */
  public function index(Request $request)
  {
    // Check if the user is a Product Manager
    if (Auth::user()->role !== 'project_manager') {
      abort(403, 'Unauthorized access.');
    }

    try {
      $cartItems = Cart::with(['product', 'user'])
        ->whereIn('status', ['Pending', 'Approved', 'Rejected'])
        ->get();

      return view('productmanager.purchase_requests', compact('cartItems'));
    } catch (\Exception $e) {
      Log::error('Purchase Requests Index Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return back()->withErrors(['error' => 'Failed to load purchase requests: ' . $e->getMessage()]);
    }
  }

  /**
   * Approve a purchase request.
   */
  public function approve(Request $request, $id)
  {
    // Check if the user is a Product Manager
    if (Auth::user()->role !== 'productmanager') {
      return response()->json([
        'success' => false,
        'message' => 'Unauthorized access.'
      ], 403);
    }

    try {
      $cartItem = Cart::findOrFail($id);

      if ($cartItem->status !== 'Pending') {
        return response()->json([
          'success' => false,
          'message' => 'This request has already been processed.'
        ], 422);
      }

      $cartItem->update(['status' => 'Approved']);

      // Notify the user who added the cart item
      Notification::create([
        'user_id' => $cartItem->user_id,
        'type' => 'purchase_approved',
        'message' => 'Your purchase request for ' . $cartItem->product->name . ' has been approved.',
        'data' => json_encode([
          'cart_id' => $cartItem->id,
          'product_name' => $cartItem->product->name,
          'quantity' => $cartItem->quantity,
        ]),
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Purchase request approved successfully.'
      ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      Log::error('Approve Purchase Request Error - Cart not found: ' . $id);
      return response()->json([
        'success' => false,
        'message' => 'Cart item not found.'
      ], 404);
    } catch (\Exception $e) {
      Log::error('Approve Purchase Request Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to approve request: ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Reject a purchase request.
   */
  public function reject(Request $request, $id)
  {
    // Check if the user is a Product Manager
    if (Auth::user()->role !== 'productmanager') {
      return response()->json([
        'success' => false,
        'message' => 'Unauthorized access.'
      ], 403);
    }

    try {
      $cartItem = Cart::findOrFail($id);

      if ($cartItem->status !== 'Pending') {
        return response()->json([
          'success' => false,
          'message' => 'This request has already been processed.'
        ], 422);
      }

      $cartItem->update(['status' => 'Rejected']);

      // Notify the user who added the cart item
      Notification::create([
        'user_id' => $cartItem->user_id,
        'type' => 'purchase_rejected',
        'message' => 'Your purchase request for ' . $cartItem->product->name . ' has been rejected.',
        'data' => json_encode([
          'cart_id' => $cartItem->id,
          'product_name' => $cartItem->product->name,
          'quantity' => $cartItem->quantity,
        ]),
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Purchase request rejected successfully.'
      ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      Log::error('Reject Purchase Request Error - Cart not found: ' . $id);
      return response()->json([
        'success' => false,
        'message' => 'Cart item not found.'
      ], 404);
    } catch (\Exception $e) {
      Log::error('Reject Purchase Request Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to reject request: ' . $e->getMessage()
      ], 500);
    }
  }
}