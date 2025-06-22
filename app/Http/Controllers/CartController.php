<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
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
        ]);
      }

      $cartCount = Cart::where('user_id', $user->id)->count();

      return response()->json([
        'success' => true,
        'cart_count' => $cartCount,
        'message' => 'Product added to cart successfully!'
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
      $response = $this->addToCart($request, $id);
      $data = json_decode($response->getContent(), true);

      if ($response->getStatusCode() === 200 && $data['success']) {
        return redirect()->route('procurement.checkout')->with('success', 'Proceeding to checkout!');
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
      $cartCount = Cart::where('user_id', $user->id)->count();

      return response()->json([
        'success' => true,
        'cart_count' => $cartCount,
        'message' => 'Cart updated successfully'
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

      $cartItem->delete();
      $cartCount = Cart::where('user_id', $user->id)->count();

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
        return [
          'id' => $cartItem->product_id,
          'name' => $cartItem->product->name,
          'price' => $cartItem->product->price,
          'quantity' => $cartItem->quantity,
          'image' => !empty($cartItem->product->image_paths) && is_array($cartItem->product->image_paths)
            ? $cartItem->product->image_paths[0]
            : null,
          'variant' => $cartItem->variant ?? 'default',
          'supplier' => $cartItem->product->supplier,
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
}