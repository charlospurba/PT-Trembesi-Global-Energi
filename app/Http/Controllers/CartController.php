<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
      Log::error('Update Cart Error: ' . $e->getMessage());
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
      Log::error('Remove Cart Error: ' . $e->getMessage());
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

  public function checkout(Request $request)
  {
    $user = Auth::user();
    $selectedIds = $request->input('selected_ids', []);

    $query = Cart::where('user_id', $user->id)->with('product');

    if (!empty($selectedIds)) {
      $query->whereIn('product_id', $selectedIds);
    }

    $cartItems = $query->get()->map(function ($cartItem) {
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

    $suppliers = array_unique(array_column($cartItems, 'supplier'));
    if (count($suppliers) > 1) {
      return redirect()->back()->withErrors(['vendor' => 'Please select products from only one vendor for checkout.']);
    }

    $totalPrice = array_sum(array_map(function ($item) {
      return $item['price'] * $item['quantity'];
    }, $cartItems));

    return view('procurement.checkout', compact('cartItems', 'totalPrice'));
  }

  public function getCartCount()
  {
    $user = Auth::user();
    $count = Cart::where('user_id', $user->id)->count();
    return response()->json(['count' => $count]);
  }

  public function submitCheckout(Request $request)
  {
    try {
      $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'country' => 'required|string|max:255',
        'postal_code' => 'required|string|max:20',
        'street_address' => 'required|string|max:500',
        'state' => 'nullable|string|max:255',
        'selected_ids' => 'required|array',
      ]);

      $user = Auth::user();
      $selectedIds = $request->input('selected_ids', []);

      Log::info('Submit Checkout - User: ' . $user->id . ', Selected IDs: ', $selectedIds);

      if (empty($selectedIds)) {
        Log::warning('No selected IDs provided for checkout');
        return response()->json([
          'success' => false,
          'message' => 'No items selected for checkout.'
        ], 422);
      }

      $cartItems = Cart::where('user_id', $user->id)
        ->whereIn('product_id', $selectedIds)
        ->with('product')
        ->get();

      if ($cartItems->isEmpty()) {
        Log::warning('No cart items found for selected IDs', ['selected_ids' => $selectedIds]);
        return response()->json([
          'success' => false,
          'message' => 'No valid items found in cart for checkout.'
        ], 422);
      }

      $suppliers = $cartItems->pluck('product.supplier')->unique()->toArray();
      if (count($suppliers) > 1) {
        Log::warning('Multiple vendors detected in checkout', ['suppliers' => $suppliers]);
        return response()->json([
          'success' => false,
          'message' => 'Checkout can only include products from one vendor.'
        ], 422);
      }

      $checkoutItems = $cartItems->map(function ($cartItem) {
        return [
          'id' => $cartItem->product_id,
          'name' => $cartItem->product->name,
          'price' => $cartItem->product->price,
          'quantity' => $cartItem->quantity,
          'variant' => $cartItem->variant ?? 'default',
          'supplier' => $cartItem->product->supplier,
        ];
      })->toArray();

      Log::info('Checkout items stored in session', ['checkout_items' => $checkoutItems]);
      session()->put('checkout_items', $checkoutItems);

      Notification::create([
        'user_id' => $user->id,
        'type' => 'order',
        'message' => 'New order placed with ' . $suppliers[0] . ' for ' . $cartItems->count() . ' items.',
        'data' => json_encode([
          'order_details' => $cartItems->map(function ($item) {
            return [
              'product_name' => $item->product->name,
              'quantity' => $item->quantity,
              'price' => $item->product->price,
            ];
          })->toArray(),
        ]),
      ]);

      Cart::where('user_id', $user->id)
        ->whereIn('product_id', $selectedIds)
        ->delete();

      return response()->json([
        'success' => true,
        'message' => 'Checkout completed successfully!'
      ]);
    } catch (\Exception $e) {
      Log::error('Checkout Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to complete checkout: ' . $e->getMessage()
      ], 500);
    }
  }

  public function generateEBilling(Request $request)
  {
    try {
      $user = Auth::user();
      $checkoutItems = session()->get('checkout_items', []);
      $selectedIds = $request->input('selected_ids', []);

      Log::info('Generate E-Billing - User: ' . $user->id . ', Session Items: ', ['checkout_items' => $checkoutItems, 'selected_ids' => $selectedIds]);

      if (empty($checkoutItems) && !empty($selectedIds)) {
        Log::info('No session items found, attempting to fetch from cart with selected IDs');
        $cartItems = Cart::where('user_id', $user->id)
          ->whereIn('product_id', $selectedIds)
          ->with('product')
          ->get();

        if ($cartItems->isEmpty()) {
          Log::warning('No cart items found for selected IDs', ['selected_ids' => $selectedIds]);
          return response()->json([
            'success' => false,
            'message' => 'No valid items found for e-billing.'
          ], 422);
        }

        $checkoutItems = $cartItems->map(function ($cartItem) {
          return [
            'id' => $cartItem->product_id,
            'name' => $cartItem->product->name,
            'price' => $cartItem->product->price,
            'quantity' => $cartItem->quantity,
            'variant' => $cartItem->variant ?? 'default',
            'supplier' => $cartItem->product->supplier,
          ];
        })->toArray();
      }

      if (empty($checkoutItems)) {
        Log::warning('No checkout items found for e-billing');
        return response()->json([
          'success' => false,
          'message' => 'No items found for e-billing. Please complete checkout first.'
        ], 422);
      }

      $suppliers = array_unique(array_column($checkoutItems, 'supplier'));
      if (count($suppliers) > 1) {
        Log::warning('Multiple vendors detected in e-billing', ['suppliers' => $suppliers]);
        return response()->json([
          'success' => false,
          'message' => 'E-Billing can only include products from one vendor.'
        ], 422);
      }

      $data = [
        'cartItems' => array_map(function ($item) {
          return [
            'name' => $item['name'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'total' => $item['price'] * $item['quantity'],
          ];
        }, $checkoutItems),
        'totalPrice' => array_sum(array_map(function ($item) {
          return $item['price'] * $item['quantity'];
        }, $checkoutItems)),
        'user' => $user,
        'vendor' => $suppliers[0],
        'date' => now()->format('Y-m-d'),
      ];

      Log::info('E-Billing data prepared', ['data' => $data]);

      $pdf = PDF::loadView('procurement.ebilling', $data);
      $filename = 'e-billing-' . time() . '.pdf';
      Storage::disk('public')->put($filename, $pdf->output());

      Notification::create([
        'user_id' => $user->id,
        'type' => 'e-billing',
        'message' => 'E-Billing generated for order with ' . $suppliers[0],
        'data' => json_encode(['pdf_path' => $filename]),
      ]);

      session()->forget('checkout_items');

      return response()->json([
        'success' => true,
        'message' => 'E-Billing generated and sent to notifications!',
        'pdf_path' => Storage::url($filename),
      ]);
    } catch (\Exception $e) {
      Log::error('E-Billing Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to generate E-Billing: ' . $e->getMessage()
      ], 500);
    }
  }
}