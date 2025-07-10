<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseRequestController extends Controller
{
  public function index(Request $request)
  {
    if (Auth::user()->role !== 'project_manager') {
      Log::warning('Unauthorized access to purchase requests', ['user_id' => Auth::id()]);
      abort(403, 'Unauthorized access.');
    }

    try {
      $cartItems = Cart::with([
        'product' => function ($query) {
          $query->select('id', 'name', 'price', 'supplier', 'image_paths');
        },
        'user' => function ($query) {
          $query->select('id', 'name', 'email');
        }
      ])
        ->whereIn('status', ['Pending', 'Approved', 'Rejected'])
        ->orderBy('created_at', 'desc')
        ->get();

      return view('projectmanager.purchase_requests', compact('cartItems'));
    } catch (\Exception $e) {
      Log::error('Purchase Requests Index Error: ' . $e->getMessage(), [
        'user_id' => Auth::id(),
        'trace' => $e->getTraceAsString()
      ]);
      return back()->withErrors(['error' => 'Failed to load purchase requests: ' . $e->getMessage()]);
    }
  }

  public function approve(Request $request, $id)
  {
    if (Auth::user()->role !== 'project_manager') {
      Log::warning('Unauthorized access to approve purchase request', ['user_id' => Auth::id(), 'cart_id' => $id]);
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

      Log::info('Purchase Request Approved', [
        'cart_id' => $id,
        'user_id' => Auth::id()
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
      Log::error('Approve Purchase Request Error: ' . $e->getMessage(), [
        'cart_id' => $id,
        'user_id' => Auth::id(),
        'trace' => $e->getTraceAsString()
      ]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to approve request: ' . $e->getMessage()
      ], 500);
    }
  }

  public function reject(Request $request, $id)
  {
    if (Auth::user()->role !== 'project_manager') {
      Log::warning('Unauthorized access to reject purchase request', ['user_id' => Auth::id(), 'cart_id' => $id]);
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

      Log::info('Purchase Request Rejected', [
        'cart_id' => $id,
        'user_id' => Auth::id()
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
      Log::error('Reject Purchase Request Error: ' . $e->getMessage(), [
        'cart_id' => $id,
        'user_id' => Auth::id(),
        'trace' => $e->getTraceAsString()
      ]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to reject request: ' . $e->getMessage()
      ], 500);
    }
  }
}