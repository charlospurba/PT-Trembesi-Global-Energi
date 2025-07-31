<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Bid;
use App\Models\Notification;
use App\Models\User;
use App\Models\PurchaseRequest;
use App\Models\PMRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
  public function addToCart(Request $request, $id)
  {
    try {
      $product = Product::findOrFail($id);
      $quantity = (int) $request->input('quantity', 1);
      $user = Auth::user();
      $note_id = $request->input('note_id'); // Get note_id from request

      if (!$user) {
        return response()->json([
          'success' => false,
          'message' => 'You must be logged in to add items to the cart'
        ], 401);
      }

      // Validate note_id and item match
      if (!$note_id) {
        return response()->json([
          'success' => false,
          'message' => 'Adding to cart is only allowed from a procurement note'
        ], 403);
      }

      $note = PMRequest::findOrFail($note_id);
      if ($note->item !== $product->name) {
        return response()->json([
          'success' => false,
          'message' => 'Selected product does not match the item in the procurement note'
        ], 422);
      }

      Log::info('Add to Cart - Product ID: ' . $id . ', Quantity: ' . $quantity . ', Available Quantity: ' . ($product->quantity ?? 'Unlimited') . ', Note ID: ' . $note_id);

      if ($quantity <= 0) {
        return response()->json([
          'success' => false,
          'message' => 'Invalid quantity'
        ], 422);
      }

      $availableQuantity = $product->quantity ?? PHP_INT_MAX;
      $cartItem = Cart::where('user_id', $user->id)
        ->where('product_id', $id)
        ->first();

      $existingQuantity = $cartItem ? $cartItem->quantity : 0;
      $totalQuantity = $existingQuantity + $quantity;

      if ($totalQuantity > $availableQuantity) {
        return response()->json([
          'success' => false,
          'message' => 'Total quantity (' . $totalQuantity . ') exceeds available quantity (' . $availableQuantity . ')'
        ], 422);
      }

      if ($cartItem) {
        $cartItem->update(['quantity' => $totalQuantity]);
      } else {
        $cartItem = Cart::create([
          'user_id' => $user->id,
          'product_id' => $product->id,
          'quantity' => $quantity,
          'variant' => $request->input('variant', 'default'),
          'status' => 'Pending',
          'note_id' => $note_id, // Store note_id in cart
        ]);
      }

      // Notify Project Manager
      $projectManagers = User::where('role', 'project_manager')->get();
      foreach ($projectManagers as $pm) {
        Notification::create([
          'user_id' => $pm->id,
          'type' => 'cart_pending',
          'message' => 'New cart item pending approval from ' . $user->name . ' for product: ' . $product->name . ' (Note ID: ' . $note_id . ')',
          'data' => json_encode([
            'cart_item' => [
              'product_id' => $product->id,
              'product_name' => $product->name,
              'quantity' => $quantity,
              'variant' => $request->input('variant', 'default'),
              'user_id' => $user->id,
              'user_name' => $user->name,
              'note_id' => $note_id,
            ],
          ]),
        ]);
      }

      $cartCount = Cart::where('user_id', $user->id)->count();

      return response()->json([
        'success' => true,
        'cart_count' => $cartCount,
        'message' => 'Product added to cart successfully! Awaiting Project Manager approval.'
      ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      Log::error('Add to Cart Error - Product or Note not found: ' . $id . ', Note ID: ' . $note_id);
      return response()->json([
        'success' => false,
        'message' => 'Product or procurement note not found'
      ], 404);
    } catch (\Exception $e) {
      Log::error('Add to Cart Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
      ], 500);
    }
  }

  public function buyNow(Request $request, $id)
  {
    Log::info('Buy Now - Product ID: ' . $id . ', Request: ', $request->all());
    try {
      $cartItem = Cart::where('user_id', Auth::id())
        ->where('product_id', $id)
        ->first();

      if ($cartItem && $cartItem->status !== 'Approved') {
        return response()->json([
          'success' => false,
          'message' => 'Item requires Project Manager approval before checkout.'
        ], 403);
      }

      // Pass note_id to addToCart
      $response = $this->addToCart($request, $id);
      $data = json_decode($response->getContent(), true);

      if ($response->getStatusCode() === 200 && $data['success']) {
        // This block seems to be misplacing the success, leading to a 403 even on success.
        // The original design of buyNow calling addToCart and then returning a 403 on success of addToCart
        // implies buyNow is meant for direct purchase *after* approval, or is meant to guide the user
        // that even if it's in the cart, it needs approval.
        // Given the flow, if addToCart succeeds, we should indicate success and possibly redirect
        // or inform about the approval process.
        // For now, I'll keep the original logic's intent, but this `if ($response->getStatusCode() === 200 && $data['success'])`
        // block might be the source of confusion about "buy now" immediately.
        return response()->json([
          'success' => false, // This seems counter-intuitive if addToCart was successful
          'message' => 'Item added to cart, but requires Project Manager approval before checkout.'
        ], 403);
      }
      return $response;
    } catch (\Exception $e) {
      Log::error('Buy Now Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
      ], 500);
    }
  }

  public function updateCart(Request $request, $id)
  {
    try {
      $user = Auth::user();
      $cartItem = Cart::where('user_id', $user->id)
        ->where('product_id', $id)
        ->first();

      if (!$cartItem) {
        return response()->json([
          'success' => false,
          'message' => 'Product not found in cart'
        ], 404);
      }

      if ($cartItem->status !== 'Pending') {
        return response()->json([
          'success' => false,
          'message' => 'Cannot update cart item. Status is ' . $cartItem->status . '.'
        ], 403);
      }

      $quantity = (int) $request->input('quantity', 1);
      $product = Product::findOrFail($id);
      $availableQuantity = $product->quantity ?? PHP_INT_MAX;

      if ($quantity <= 0) {
        $cartItem->delete();
        $cartCount = Cart::where('user_id', $user->id)->count();
        return response()->json([
          'success' => true,
          'cart_count' => $cartCount,
          'message' => 'Product removed from cart'
        ]);
      }

      if ($quantity > $availableQuantity) {
        return response()->json([
          'success' => false,
          'message' => 'Requested quantity exceeds available quantity (' . $availableQuantity . ')'
        ], 422);
      }

      $cartItem->update(['quantity' => $quantity]);

      // Notify Project Manager of update
      $projectManagers = User::where('role', 'project_manager')->get();
      foreach ($projectManagers as $pm) {
        Notification::create([
          'user_id' => $pm->id,
          'type' => 'cart_updated',
          'message' => 'Cart item updated by ' . $user->name . ' for product: ' . $product->name . ' (Quantity: ' . $quantity . ')',
          'data' => json_encode([
            'cart_item' => [
              'product_id' => $product->id,
              'product_name' => $product->name,
              'quantity' => $quantity,
              'variant' => $cartItem->variant,
              'user_id' => $user->id,
              'user_name' => $user->name,
              'note_id' => $cartItem->note_id,
            ],
          ]),
        ]);
      }

      $cartCount = Cart::where('user_id', $user->id)->count();

      return response()->json([
        'success' => true,
        'cart_count' => $cartCount,
        'message' => 'Cart updated successfully, awaiting Project Manager approval.'
      ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      Log::error('Update Cart Error - Product not found: ' . $id);
      return response()->json([
        'success' => false,
        'message' => 'Product not found'
      ], 404);
    } catch (\Exception $e) {
      Log::error('Update Cart Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to update cart: ' . $e->getMessage()
      ], 500);
    }
  }

  public function removeFromCart($id)
  {
    try {
      $user = Auth::user();
      $cartItem = Cart::where('user_id', $user->id)
        ->where('product_id', $id)
        ->first();

      if (!$cartItem) {
        return response()->json([
          'success' => false,
          'message' => 'Product not found in cart'
        ], 404);
      }

      $product = Product::findOrFail($id);
      $cartItem->delete();
      $cartCount = Cart::where('user_id', $user->id)->count();

      // Notify Project Manager of removal
      $projectManagers = User::where('role', 'project_manager')->get();
      foreach ($projectManagers as $pm) {
        Notification::create([
          'user_id' => $pm->id,
          'type' => 'cart_removed',
          'message' => 'Cart item removed by ' . $user->name . ' for product: ' . $product->name,
          'data' => json_encode([
            'cart_item' => [
              'product_id' => $product->id,
              'product_name' => $product->name,
              'user_id' => $user->id,
              'user_name' => $user->name,
              'note_id' => $cartItem->note_id,
            ],
          ]),
        ]);
      }

      return response()->json([
        'success' => true,
        'cart_count' => $cartCount,
        'message' => 'Product removed from cart'
      ]);
    } catch (\Exception $e) {
      Log::error('Remove Cart Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to remove product: ' . $e->getMessage()
      ], 500);
    }
  }

  public function showCart()
  {
    $user = Auth::user();
    $cartItems = Cart::where('user_id', $user->id)
      ->with('product')
      ->get()
      ->map(function ($cartItem) {
        $acceptedBid = Bid::where('product_id', $cartItem->product_id)
          ->where('user_id', Auth::id())
          ->where('cart_id', $cartItem->id)
          ->where('status', 'Accepted')
          ->latest()
          ->first();
        $price = $acceptedBid ? $acceptedBid->bid_price : $cartItem->product->price;

        return [
          'id' => $cartItem->product_id,
          'name' => $cartItem->product->name,
          'price' => $price,
          'quantity' => $cartItem->quantity,
          'image' => !empty($cartItem->product->image_paths) && is_array($cartItem->product->image_paths)
            ? $cartItem->product->image_paths[0]
            : null,
          'variant' => $cartItem->variant ?? 'default',
          'supplier' => $cartItem->product->supplier,
          'status' => $cartItem->status,
          'is_bid_price' => $acceptedBid ? true : false,
          'note_id' => $cartItem->note_id,
        ];
      })->toArray();

    $totalPrice = array_sum(array_map(function ($item) {
      return $item['price'] * $item['quantity'];
    }, $cartItems));

    return view('procurement.cart', compact('cartItems', 'totalPrice'));
  }

  public function getCartCount()
  {
    $user = Auth::user();
    $count = Cart::where('user_id', $user->id)->count();
    return response()->json(['count' => $count]);
  }

  public function submitBid(Request $request, $productId)
  {
    try {
      $user = Auth::user();
      if (!$user) {
        return response()->json([
          'success' => false,
          'message' => 'You must be logged in to submit a bid'
        ], 401);
      }

      $product = Product::findOrFail($productId);
      $bidPrice = (float) $request->input('bid_price');
      $cartItem = Cart::where('user_id', $user->id)
        ->where('product_id', $productId)
        ->first();

      if (!$cartItem) {
        return response()->json([
          'success' => false,
          'message' => 'Product not found in cart'
        ], 404);
      }

      if ($bidPrice <= 0) {
        return response()->json([
          'success' => false,
          'message' => 'Bid price must be a positive number'
        ], 422);
      }

      // Check bid count limit for this cart item
      $bidCount = Bid::where('user_id', $user->id)
        ->where('product_id', $productId)
        ->where('cart_id', $cartItem->id)
        ->count();

      if ($bidCount >= 3) {
        return response()->json([
          'success' => false,
          'message' => 'You have reached the maximum of 3 bids for this product in this cart'
        ], 422);
      }

      $bid = Bid::create([
        'user_id' => $user->id,
        'product_id' => $productId,
        'vendor_id' => $product->vendor_id,
        'bid_price' => $bidPrice,
        'cart_id' => $cartItem->id,
        'status' => 'Pending',
      ]);

      // Notify vendor
      Notification::create([
        'user_id' => $product->vendor_id,
        'type' => 'bid_submitted',
        'message' => 'A new bid has been submitted for ' . $product->name . ' with price Rp ' . number_format($bidPrice, 0, ',', '.') . '.',
        'data' => json_encode([
          'bid_id' => $bid->id,
          'product_id' => $productId,
          'bid_price' => $bidPrice,
          'cart_id' => $cartItem->id,
          'note_id' => $cartItem->note_id,
        ]),
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Bid submitted successfully!'
      ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      Log::error('Submit Bid Error - Product not found: ' . $productId);
      return response()->json([
        'success' => false,
        'message' => 'Product not found'
      ], 404);
    } catch (\Exception $e) {
      Log::error('Submit Bid Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to submit bid: ' . $e->getMessage()
      ], 500);
    }
  }

  public function requestPurchase(Request $request)
  {
    try {
      $user = Auth::user();
      if (!$user) {
        return response()->json([
          'success' => false,
          'message' => 'You must be logged in to submit a purchase request'
        ], 401);
      }

      $selectedIds = $request->input('selected_ids', []);

      // Validate input
      if (empty($selectedIds)) {
        Log::warning('Request Purchase - No items selected', ['user_id' => $user->id]);
        return response()->json([
          'success' => false,
          'message' => 'No items selected for purchase request.'
        ], 422);
      }

      // Fetch cart items for the selected IDs
      $cartItems = Cart::where('user_id', $user->id)
        ->whereIn('product_id', $selectedIds)
        ->with([
          'product' => function ($query) {
            $query->select('id', 'name', 'price', 'supplier');
          }
        ])
        ->get();

      if ($cartItems->isEmpty()) {
        Log::warning('Request Purchase - No valid cart items found', [
          'user_id' => $user->id,
          'selected_ids' => $selectedIds
        ]);
        return response()->json([
          'success' => false,
          'message' => 'No valid items found in cart for purchase request.'
        ], 422);
      }

      // Check for unprocessed items
      $unprocessedItems = $cartItems->whereNotIn('status', ['Pending']);
      if ($unprocessedItems->isNotEmpty()) {
        Log::warning('Request Purchase - Non-pending items detected', [
          'user_id' => $user->id,
          'non_pending_items' => $unprocessedItems->pluck('product_id')->toArray()
        ]);
        return response()->json([
          'success' => false,
          'message' => 'Some selected items have already been processed (Approved/Rejected).'
        ], 422);
      }

      // Check for existing purchase requests
      $existingRequests = PurchaseRequest::whereIn('cart_id', $cartItems->pluck('id'))
        ->where('status', 'Pending')
        ->pluck('cart_id')
        ->toArray();
      if (!empty($existingRequests)) {
        Log::warning('Request Purchase - Duplicate purchase requests detected', [
          'user_id' => $user->id,
          'cart_ids' => $existingRequests
        ]);
        return response()->json([
          'success' => false,
          'message' => 'Some items already have pending purchase requests.'
        ], 422);
      }

      // Create PurchaseRequest entries
      $purchaseRequestIds = [];
      foreach ($cartItems as $cartItem) {
        $acceptedBid = Bid::where('product_id', $cartItem->product_id)
          ->where('user_id', $user->id)
          ->where('cart_id', $cartItem->id)
          ->where('status', 'Accepted')
          ->latest()
          ->first();
        $price = $acceptedBid ? $acceptedBid->bid_price : $cartItem->product->price;

        $purchaseRequest = PurchaseRequest::create([
          'user_id' => $user->id,
          'product_id' => $cartItem->product_id,
          'cart_id' => $cartItem->id,
          'quantity' => $cartItem->quantity,
          'price' => $price,
          'supplier' => $cartItem->product->supplier,
          'status' => 'Pending',
          'submitted_at' => now(),
          'note_id' => $cartItem->note_id, // Store note_id in purchase request
        ]);
        $purchaseRequestIds[] = $purchaseRequest->id;
      }

      // Notify Project Managers
      $projectManagers = User::where('role', 'project_manager')->get();
      if ($projectManagers->isEmpty()) {
        Log::warning('Request Purchase - No project managers found', ['user_id' => $user->id]);
        return response()->json([
          'success' => false,
          'message' => 'No project managers available to process the request.'
        ], 422);
      }

      foreach ($cartItems as $cartItem) {
        foreach ($projectManagers as $pm) {
          Notification::create([
            'user_id' => $pm->id,
            'type' => 'purchase_request',
            'message' => "New purchase request from {$user->name} for product: {$cartItem->product->name} (Note ID: {$cartItem->note_id})",
            'data' => json_encode([
              'purchase_request' => [
                'cart_id' => $cartItem->id,
                'product_id' => $cartItem->product->id,
                'product_name' => $cartItem->product->name,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
                'variant' => $cartItem->variant ?? 'default',
                'user_id' => $user->id,
                'user_name' => $user->name,
                'note_id' => $cartItem->note_id,
              ],
            ]),
          ]);
        }
      }

      Log::info('Request Purchase - Success', [
        'user_id' => $user->id,
        'cart_item_ids' => $cartItems->pluck('id')->toArray(),
        'purchase_request_ids' => $purchaseRequestIds
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Purchase request submitted successfully! Awaiting Project Manager approval.',
        'purchase_request_ids' => $purchaseRequestIds
      ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      Log::error('Request Purchase Error - Model not found: ' . $e->getMessage(), [
        'user_id' => Auth::id(),
        'trace' => $e->getTraceAsString()
      ]);
      return response()->json([
        'success' => false,
        'message' => 'One or more items not found in the cart.'
      ], 404);
    } catch (\Exception $e) {
      Log::error('Request Purchase Error: ' . $e->getMessage(), [
        'user_id' => Auth::id(),
        'trace' => $e->getTraceAsString()
      ]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to submit purchase request: ' . $e->getMessage()
      ], 500);
    }
  }
}