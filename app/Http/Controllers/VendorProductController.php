<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class VendorProductController extends Controller
{
  public function index()
  {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Unauthorized');
    }

    $products = Product::where('vendor_id', $user->id)->get();
    return view('vendor.vendor_myproducts', compact('products'));
  }

  public function create()
  {
    return view('vendor.add_product');
  }

  public function store(Request $request)
  {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Unauthorized');
    }

    $validated = $request->validate([
      'category' => 'required|string|max:255',
      'brand' => 'nullable|string|max:255',
      'supplier' => 'required|string|max:255',
      'name' => 'required|string|max:255',
      'specification' => 'required|string',
      'custom_spec' => 'nullable|string',
      'quantity' => 'required|integer|min:1',
      'description' => 'nullable|string',
      'address' => 'nullable|string|max:255',
      'price' => 'required|numeric|min:0',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $validated['vendor_id'] = $user->id;

    if ($request->hasFile('image')) {
      $path = $request->file('image')->store('product_images', 'public');
      $validated['image_path'] = $path;
    }

    Product::create($validated);

    return redirect()->route('vendor.myproducts')->with('success', 'Produk berhasil ditambahkan.');
  }

  public function edit($id)
  {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Unauthorized');
    }

    $product = Product::findOrFail($id);

    if ($product->vendor_id !== $user->id) {
      abort(403);
    }

    return view('vendor.edit_product', compact('product'));
  }

  public function update(Request $request, $id)
  {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Unauthorized');
    }

    $product = Product::findOrFail($id);

    if ($product->vendor_id !== $user->id) {
      abort(403);
    }

    $validated = $request->validate([
      'category' => 'required|string|max:255',
      'brand' => 'nullable|string|max:255',
      'supplier' => 'required|string|max:255',
      'name' => 'required|string|max:255',
      'specification' => 'required|string',
      'custom_spec' => 'nullable|string',
      'quantity' => 'required|integer|min:1',
      'description' => 'nullable|string',
      'address' => 'nullable|string|max:255',
      'price' => 'required|numeric|min:0',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'remove_image' => 'nullable|in:0,1',
    ]);

    Log::info('remove_image value: ' . $request->input('remove_image')); // Debug
    if ($request->input('remove_image') === '1') {
      Log::info('Attempting to remove image: ' . $product->image_path); // Debug
      if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
        Storage::disk('public')->delete($product->image_path);
        Log::info('Image deleted: ' . $product->image_path);
        $validated['image_path'] = null;
      } else {
        Log::warning('Image not found in storage: ' . ($product->image_path ?? 'null'));
        $validated['image_path'] = null;
      }
    } elseif ($request->hasFile('image')) {
      Log::info('Uploading new image'); // Debug
      if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
        Storage::disk('public')->delete($product->image_path);
        Log::info('Old image deleted: ' . $product->image_path);
      }
      $path = $request->file('image')->store('product_images', 'public');
      $validated['image_path'] = $path;
      Log::info('New image stored: ' . $path);
    }

    $product->update($validated);
    Log::info('Product updated', $validated); // Debug

    return redirect()->route('vendor.myproducts')->with('success', 'Produk berhasil diperbarui.');
  }

  public function destroy($id)
  {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (!$user) {
      return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $product = Product::findOrFail($id);

    if ($product->vendor_id !== $user->id) {
      return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    if ($product->image_path) {
      Storage::disk('public')->delete($product->image_path);
    }

    $product->delete();

    return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
  }

  public function show($id)
  {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Unauthorized');
    }

    $product = Product::findOrFail($id);

    if ($product->vendor_id !== $user->id) {
      abort(403);
    }

    return view('vendor.product_detail', compact('product'));
  }
}