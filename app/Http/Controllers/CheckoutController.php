<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Bid;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\PDF;

class CheckoutController extends Controller
{
  public function checkout(Request $request)
  {
    $user = Auth::user();
    $selectedIds = $request->input('selected_ids', []);

    $query = Cart::where('user_id', $user->id)
      ->where('status', 'Approved')
      ->with([
        'product' => function ($query) {
          $query->select('id', 'name', 'price', 'supplier', 'vendor_id', 'image_paths');
        }
      ]);

    if (!empty($selectedIds)) {
      $query->whereIn('product_id', $selectedIds);
    }

    $cartItems = $query->get()->map(function ($cartItem) use ($user) {
      $acceptedBid = Bid::where('product_id', $cartItem->product_id)
        ->where('user_id', $user->id)
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
        'vendor_id' => $cartItem->product->vendor_id,
        'is_bid_price' => $acceptedBid ? true : false,
      ];
    })->toArray();

    if (empty($cartItems)) {
      return redirect()->route('procurement.cart')->withErrors(['status' => 'No approved items available for checkout.']);
    }

    $suppliers = array_unique(array_column($cartItems, 'supplier'));
    $vendorIds = array_unique(array_column($cartItems, 'vendor_id'));

    if (count($suppliers) > 1 || count($vendorIds) > 1) {
      return redirect()->back()->withErrors(['vendor' => 'Please select products from only one vendor for checkout.']);
    }

    $totalPrice = array_sum(array_map(function ($item) {
      return $item['price'] * $item['quantity'];
    }, $cartItems));

    return view('procurement.checkout', compact('cartItems', 'totalPrice'));
  }

  public function submitCheckout(Request $request)
  {
    try {
      $validated = $this->validateCheckout($request);
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

      $cartItems = $this->fetchCartItems($user->id, $selectedIds);
      if ($cartItems->isEmpty()) {
        Log::warning('No cart items found for selected IDs', ['selected_ids' => $selectedIds]);
        return response()->json([
          'success' => false,
          'message' => 'No valid items found in cart for checkout.'
        ], 422);
      }

      // Check if all selected items are approved
      $unapprovedItems = $cartItems->where('status', '!=', 'Approved');
      if ($unapprovedItems->isNotEmpty()) {
        Log::warning('Unapproved items detected in checkout', ['unapproved_items' => $unapprovedItems->pluck('product_id')->toArray()]);
        return response()->json([
          'success' => false,
          'message' => 'Some items are not approved by the Project Manager.'
        ], 422);
      }

      $suppliers = $cartItems->pluck('product.supplier')->unique()->toArray();
      $vendorIds = $cartItems->pluck('product.vendor_id')->unique()->toArray();

      if (count($suppliers) > 1 || count($vendorIds) > 1) {
        Log::warning('Multiple vendors detected in checkout', ['suppliers' => $suppliers, 'vendor_ids' => $vendorIds]);
        return response()->json([
          'success' => false,
          'message' => 'Checkout can only include products from one vendor.'
        ], 422);
      }

      if (empty($vendorIds[0]) || !User::where('id', $vendorIds[0])->where('role', 'vendor')->exists()) {
        Log::error('Invalid or missing vendor_id', ['vendor_id' => $vendorIds[0] ?? 'null']);
        return response()->json([
          'success' => false,
          'message' => 'Invalid vendor for selected products.'
        ], 422);
      }

      $totalPrice = $cartItems->sum(function ($item) use ($user) {
        $acceptedBid = Bid::where('product_id', $item->product_id)
          ->where('user_id', $user->id)
          ->where('status', 'Accepted')
          ->latest()
          ->first();
        $price = $acceptedBid ? $acceptedBid->bid_price : $item->product->price;
        return $price * $item->quantity;
      });

      // Create order
      $order = $this->createOrder($user->id, $suppliers[0], $totalPrice, $validated, $vendorIds[0]);

      // Create order items and update stock
      $checkoutItems = $this->createOrderItemsAndUpdateStock($order, $cartItems, $user->id);

      // Create notifications
      $this->createOrderNotification($user->id, $suppliers[0], $cartItems, $order->id);
      $this->createVendorNotification($vendorIds[0], $suppliers[0], $cartItems, $order->id);

      // Generate e-billing PDF
      $pdfPath = $this->generateEBillingPDF($user, $checkoutItems, $suppliers[0], $totalPrice);
      $this->createEBillingNotification($user->id, $suppliers[0], $pdfPath, $order->id);

      // Clear cart items
      Cart::where('user_id', $user->id)
        ->whereIn('product_id', $selectedIds)
        ->delete();

      Log::info('Checkout Completed Successfully', ['order_id' => $order->id, 'vendor_id' => $vendorIds[0]]);

      return response()->json([
        'success' => true,
        'message' => 'Checkout completed successfully! E-Billing has been generated.',
        'order_id' => $order->id,
        'redirect' => route('procurement.dashboardproc'),
      ]);
    } catch (\Exception $e) {
      Log::error('Checkout Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to complete checkout: ' . $e->getMessage()
      ], 500);
    }
  }

  protected function validateCheckout(Request $request)
  {
    return $request->validate([
      'full_name' => 'required|string|max:255',
      'phone_number' => 'required|string|max:20',
      'country' => 'required|string|max:255',
      'postal_code' => 'required|string|max:20',
      'street_address' => 'required|string|max:500',
      'city' => 'required|string|max:255',
      'state' => 'nullable|string|max:255',
      'selected_ids' => 'required|array',
    ]);
  }

  protected function fetchCartItems($userId, array $selectedIds)
  {
    return Cart::where('user_id', $userId)
      ->whereIn('product_id', $selectedIds)
      ->where('status', 'Approved')
      ->with([
        'product' => function ($query) {
          $query->select('id', 'name', 'price', 'supplier', 'vendor_id', 'image_paths', 'quantity');
        }
      ])
      ->get();
  }

  protected function createOrder($userId, $vendor, $totalPrice, array $validated, $vendorId)
  {
    return Order::create([
      'user_id' => $userId,
      'vendor_id' => $vendorId,
      'vendor' => $vendor,
      'total_price' => $totalPrice,
      'full_name' => $validated['full_name'],
      'phone_number' => $validated['phone_number'],
      'country' => $validated['country'],
      'postal_code' => $validated['postal_code'],
      'street_address' => $validated['street_address'],
      'state' => $validated['state'],
      'city' => $validated['city'],
      'status' => 'Awaiting Shipment',
    ]);
  }

  protected function createOrderItemsAndUpdateStock($order, $cartItems, $userId)
  {
    return $cartItems->map(function ($cartItem) use ($order, $userId) {
      $acceptedBid = Bid::where('product_id', $cartItem->product_id)
        ->where('user_id', $userId)
        ->where('status', 'Approved')
        ->latest()
        ->first();

      $price = $acceptedBid ? $acceptedBid->bid_price : $cartItem->product->price;

      OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $cartItem->product_id,
        'name' => $cartItem->product->name,
        'price' => $price,
        'quantity' => $cartItem->quantity,
        'variant' => $cartItem->variant ?? 'default',
      ]);

      $product = Product::findOrFail($cartItem->product_id);
      $newQuantity = $product->quantity - $cartItem->quantity;
      if ($newQuantity < 0) {
        throw new \Exception('Insufficient stock for product: ' . $product->name);
      }
      $product->update(['quantity' => $newQuantity]);

      return [
        'id' => $cartItem->product_id,
        'name' => $cartItem->product->name,
        'price' => $price,
        'quantity' => $cartItem->quantity,
        'variant' => $cartItem->variant ?? 'default',
        'supplier' => $cartItem->product->supplier,
        'is_bid_price' => $acceptedBid ? true : false,
      ];
    })->toArray();
  }

  protected function createOrderNotification($userId, $vendor, $cartItems, $orderId)
  {
    $itemsData = $cartItems->map(function ($item) use ($userId) {
      $acceptedBid = Bid::where('product_id', $item->product_id)
        ->where('user_id', $userId)
        ->where('status', 'Approved')
        ->latest()
        ->first();
      $price = $acceptedBid ? $acceptedBid->bid_price : $item->product->price;

      return [
        'product_name' => $item->product->name,
        'quantity' => $item->quantity,
        'price' => $price,
        'is_bid_price' => $acceptedBid ? true : false,
      ];
    })->toArray();

    Notification::create([
      'user_id' => $userId,
      'type' => 'order',
      'message' => 'New order placed with ' . $vendor . ' for ' . $cartItems->count() . ' items.',
      'data' => json_encode([
        'order_id' => $orderId,
        'order_details' => $itemsData,
      ]),
    ]);
  }

  protected function createVendorNotification($vendorId, $vendor, $cartItems, $orderId)
  {
    $itemsData = $cartItems->map(function ($item) use ($vendorId) {
      $acceptedBid = Bid::where('product_id', $item->product_id)
        ->where('vendor_id', $vendorId)
        ->where('status', 'Approved')
        ->latest()
        ->first();
      $price = $acceptedBid ? $acceptedBid->bid_price : $item->product->price;

      return [
        'product_name' => $item->product->name,
        'quantity' => $item->quantity,
        'price' => $price,
        'is_bid_price' => $acceptedBid ? true : false,
      ];
    })->toArray();

    Notification::create([
      'user_id' => $vendorId,
      'type' => 'order',
      'message' => 'New order received from ' . $vendor . ' for ' . $cartItems->count() . ' items.',
      'data' => json_encode([
        'order_id' => $orderId,
        'order_details' => $itemsData,
      ]),
    ]);
  }

  protected function generateEBillingPDF($user, array $checkoutItems, $vendor, $totalPrice)
  {
    try {
      $data = [
        'cartItems' => array_map(function ($item) {
          return [
            'name' => $item['name'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'total' => $item['price'] * $item['quantity'],
            'is_bid_price' => $item['is_bid_price'],
          ];
        }, $checkoutItems),
        'totalPrice' => $totalPrice,
        'user' => $user,
        'vendor' => $vendor,
        'date' => now()->format('Y-m-d'),
      ];

      Log::info('Generating E-Billing PDF', ['data' => $data]);

      $pdf = PDF::loadView('procurement.ebilling_pdf', $data);
      $filename = 'e-billing-' . time() . '.pdf';
      Storage::disk('public')->put($filename, $pdf->output());

      if (!Storage::disk('public')->exists($filename)) {
        Log::error('E-Billing PDF failed to save', ['filename' => $filename]);
        throw new \Exception('Failed to save E-Billing PDF');
      }

      Log::info('E-Billing PDF saved successfully', ['filename' => $filename]);

      return $filename;
    } catch (\Exception $e) {
      Log::error('E-Billing PDF Generation Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      throw $e;
    }
  }

  protected function createEBillingNotification($userId, $vendor, $pdfPath, $orderId)
  {
    Notification::create([
      'user_id' => $userId,
      'type' => 'e-billing',
      'message' => 'E-Billing generated for order with ' . $vendor,
      'data' => json_encode([
        'pdf_path' => $pdfPath,
        'order_id' => $orderId,
      ]),
    ]);
  }

  public function generateEBilling(Request $request)
  {
    try {
      $user = Auth::user();
      $orderId = $request->input('order_id');
      $order = Order::findOrFail($orderId);

      if ($order->user_id !== $user->id) {
        return response()->json([
          'success' => false,
          'message' => 'Unauthorized access to order.'
        ], 403);
      }

      $orderItems = OrderItem::where('order_id', $orderId)->with('product')->get();
      $checkoutItems = $orderItems->map(function ($item) use ($user) {
        $acceptedBid = Bid::where('product_id', $item->product_id)
          ->where('user_id', $user->id)
          ->where('status', 'Approved')
          ->latest()
          ->first();

        return [
          'id' => $item->product_id,
          'name' => $item->name,
          'price' => $item->price,
          'quantity' => $item->quantity,
          'variant' => $item->variant,
          'supplier' => $item->product->supplier,
          'is_bid_price' => $acceptedBid ? true : false,
        ];
      })->toArray();

      $totalPrice = $order->total_price;
      $vendor = $order->vendor;

      $pdfPath = $this->generateEBillingPDF($user, $checkoutItems, $vendor, $totalPrice);
      $this->createEBillingNotification($user->id, $vendor, $pdfPath, $orderId);

      return response()->json([
        'success' => true,
        'message' => 'E-Billing generated and sent to notifications!',
        'pdf_path' => Storage::url($pdfPath),
      ]);
    } catch (\Exception $e) {
      Log::error('E-Billing Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json([
        'success' => false,
        'message' => 'Failed to generate E-Billing: ' . $e->getMessage()
      ], 500);
    }
  }

  public function viewEBilling($notificationId)
  {
    $user = Auth::user();

    $notification = Notification::where('id', $notificationId)
      ->where('user_id', $user->id)
      ->where('type', 'e-billing')
      ->firstOrFail();

    $data = json_decode($notification->data, true);
    $pdfPath = $data['pdf_path'] ?? null;
    $orderId = $data['order_id'] ?? null;

    if (!$pdfPath || !Storage::disk('public')->exists($pdfPath)) {
      abort(404, 'E-Billing PDF not found.');
    }

    $order = Order::findOrFail($orderId);
    $orderItems = OrderItem::where('order_id', $orderId)->get();

    return view('procurement.ebilling', [
      'pdfUrl' => Storage::url($pdfPath),
      'order' => $order,
      'orderItems' => $orderItems,
    ]);
  }
}