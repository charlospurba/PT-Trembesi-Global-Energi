<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Bid;
use App\Models\Notification;
use App\Models\User;
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

      if (!$user) {
        return response()->json([
          'success' => false,
          'message' => 'You must be logged in to add items to the cart'
        ], 401);
      }

      Log::info('Add to Cart - Product ID: ' . $id . ', Quantity: ' . $quantity . ', Available Quantity: ' . ($product->quantity ?? 'Unlimited'));

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
        Cart::create([
          'user_id' => $user->id,
          'product_id' => $product->id,
          'quantity' => $quantity,
          'variant' => $request->input('variant', 'default'),
          'status' => 'Pending',
        ]);

        // Notify Project Manager
        $projectManagers = User::where('role', 'productmanager')->get();
        foreach ($projectManagers as $pm) {
          Notification::create([
            'user_id' => $pm->id,
            'type' => 'cart_pending',
            'message' => 'New cart item pending approval from ' . $user->name . ' for product: ' . $product->name,
            'data' => json_encode([
              'cart_item' => [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'variant' => $request->input('variant', 'default'),
                'user_id' => $user->id,
                'user_name' => $user->name,
              ],
            ]),
          ]);
        }
      }

      $cartCount = Cart::where('user_id', $user->id)->count();

      return response()->json([
        'success' => true,
        'cart_count' => $cartCount,
        'message' => 'Product added to cart successfully! Awaiting Project Manager approval.'
      ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      Log::error('Add to Cart Error - Product not found: ' . $id);
      return response()->json([
        'success' => false,
        'message' => 'Product not found'
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

      $response = $this->addToCart($request, $id);
      $data = json_decode($response->getContent(), true);

      if ($response->getStatusCode() === 200 && $data['success']) {
        return response()->json([
          'success' => false,
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
      $projectManagers = User::where('role', 'productmanager')->get();
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
      $projectManagers = User::where('role', 'productmanager')->get();
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

      if ($bidPrice <= 0) {
        return response()->json([
          'success' => false,
          'message' => 'Bid price must be a positive number'
        ], 422);
      }

      // Check bid count limit
      $bidCount = Bid::where('user_id', $user->id)
        ->where('product_id', $productId)
        ->count();

      if ($bidCount >= 3) {
        return response()->json([
          'success' => false,
          'message' => 'You have reached the maximum of 3 bids for this product'
        ], 422);
      }

      $bid = Bid::create([
        'user_id' => $user->id,
        'product_id' => $productId,
        'vendor_id' => $product->vendor_id,
        'bid_price' => $bidPrice,
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
      $selectedIds = $request->input('selected_ids', []);

      if (empty($selectedIds)) {
        return response()->json([
          'success' => false,
          'message' => 'No items selected for purchase request.'
        ], 422);
      }

      $cartItems = Cart::where('user_id', $user->id)
        ->whereIn('product_id', $selectedIds)
        ->with('product')
        ->get();

      if ($cartItems->isEmpty()) {
        return response()->json([
          'success' => false,
          'message' => 'No valid items found in cart for purchase request.'
        ], 422);
      }

      foreach ($cartItems as $cartItem) {
        if ($cartItem->status !== 'Pending') {
          return response()->json([
            'success' => false,
            'message' => 'Some items have already been processed.'
          ], 422);
        }

        // Notify Project Manager
        $projectManagers = User::where('role', 'productmanager')->get();
        foreach ($projectManagers as $pm) {
          Notification::create([
            'user_id' => $pm->id,
            'type' => 'cart_pending',
            'message' => 'Purchase request from ' . $user->name . ' for product: ' . $cartItem->product->name,
            'data' => json_encode([
              'cart_item' => [
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'quantity' => $cartItem->quantity,
                'variant' => $cartItem->variant,
                'user_id' => $user->id,
                'user_name' => $user->name,
              ],
            ]),
          ]);
        }
      }

      return response()->json([
        'success' => true,
        'message' => 'Purchase request submitted successfully! Awaiting Project Manager approval.'
      ]);
    } catch (\Exception $e) {
      Log::error('Request Purchase Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to submit purchase request: ' . $e->getMessage()
      ], 500);
    }
  }
}