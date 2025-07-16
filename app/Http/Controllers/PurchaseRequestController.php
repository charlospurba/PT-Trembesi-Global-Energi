<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
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
      $purchaseRequests = PurchaseRequest::with([
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

      return view('projectmanager.purchase_requests', compact('purchaseRequests'));
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
      Log::warning('Unauthorized access to approve purchase request', ['user_id' => Auth::id(), 'purchase_request_id' => $id]);
      return response()->json([
        'success' => false,
        'message' => 'Unauthorized access.'
      ], 403);
    }

    try {
      $purchaseRequest = PurchaseRequest::findOrFail($id);

      if ($purchaseRequest->status !== 'Pending') {
        return response()->json([
          'success' => false,
          'message' => 'This request has already been processed.'
        ], 422);
      }

      $purchaseRequest->update([
        'status' => 'Approved',
        'approved_at' => now(),
      ]);

      // Update associated cart item status, if it exists
      if ($purchaseRequest->cart_id) {
        $cartItem = $purchaseRequest->cart;
        if ($cartItem) {
          $cartItem->update(['status' => 'Approved']);
        }
      }

      Notification::create([
        'user_id' => $purchaseRequest->user_id,
        'type' => 'purchase_approved',
        'message' => 'Your purchase request for ' . $purchaseRequest->product->name . ' has been approved.',
        'data' => json_encode([
          'purchase_request_id' => $purchaseRequest->id,
          'product_name' => $purchaseRequest->product->name,
          'quantity' => $purchaseRequest->quantity,
        ]),
      ]);

      Log::info('Purchase Request Approved', [
        'purchase_request_id' => $id,
        'user_id' => Auth::id()
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Purchase request approved successfully.'
      ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      Log::error('Approve Purchase Request Error - Purchase request not found: ' . $id);
      return response()->json([
        'success' => false,
        'message' => 'Purchase request not found.'
      ], 404);
    } catch (\Exception $e) {
      Log::error('Approve Purchase Request Error: ' . $e->getMessage(), [
        'purchase_request_id' => $id,
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
      Log::warning('Unauthorized access to reject purchase request', ['user_id' => Auth::id(), 'purchase_request_id' => $id]);
      return response()->json([
        'success' => false,
        'message' => 'Unauthorized access.'
      ], 403);
    }

    try {
      $purchaseRequest = PurchaseRequest::findOrFail($id);

      if ($purchaseRequest->status !== 'Pending') {
        return response()->json([
          'success' => false,
          'message' => 'This request has already been processed.'
        ], 422);
      }

      $purchaseRequest->update([
        'status' => 'Rejected',
        'rejected_at' => now(),
      ]);

      // Update associated cart item status, if it exists
      if ($purchaseRequest->cart_id) {
        $cartItem = $purchaseRequest->cart;
        if ($cartItem) {
          $cartItem->update(['status' => 'Rejected']);
        }
      }

      Notification::create([
        'user_id' => $purchaseRequest->user_id,
        'type' => 'purchase_rejected',
        'message' => 'Your purchase request for ' . $purchaseRequest->product->name . ' has been rejected.',
        'data' => json_encode([
          'purchase_request_id' => $purchaseRequest->id,
          'product_name' => $purchaseRequest->product->name,
          'quantity' => $purchaseRequest->quantity,
        ]),
      ]);

      Log::info('Purchase Request Rejected', [
        'purchase_request_id' => $id,
        'user_id' => Auth::id()
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Purchase request rejected successfully.'
      ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      Log::error('Reject Purchase Request Error - Purchase request not found: ' . $id);
      return response()->json([
        'success' => false,
        'message' => 'Purchase request not found.'
      ], 404);
    } catch (\Exception $e) {
      Log::error('Reject Purchase Request Error: ' . $e->getMessage(), [
        'purchase_request_id' => $id,
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