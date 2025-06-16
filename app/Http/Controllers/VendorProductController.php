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
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Unauthorized');
    }

    $validated = $request->validate([
      'category' => 'required|string|max:255',
      'supplier' => 'required|string|max:255',
      'brand' => 'nullable|string|max:255',
      'name' => 'required|string|max:255',
      'specification' => 'required|string|max:255',
      'unit' => 'required|string|max:255',
      'quantity' => 'required|integer|min:1',
      'price' => 'required|numeric|min:0',
      'description' => 'nullable|string',
      'address' => 'nullable|string|max:255',
      'image_paths' => 'nullable|array',
      'image_paths.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
    ]);

    $validated['vendor_id'] = $user->id;

    if ($request->hasFile('image_paths')) {
      $imagePaths = [];
      foreach ($request->file('image_paths') as $image) {
        $path = $image->store('product_images', 'public');
        $imagePaths[] = $path;
      }
      $validated['image_paths'] = $imagePaths;
    }

    Product::create($validated);

    return redirect()->route('vendor.myproducts')->with('success', 'Produk berhasil ditambahkan.');
  }

  public function edit($id)
  {
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
      'supplier' => 'required|string|max:255',
      'brand' => 'nullable|string|max:255',
      'name' => 'required|string|max:255',
      'specification' => 'required|string|max:255',
      'unit' => 'required|string|max:255',
      'quantity' => 'required|integer|min:1',
      'price' => 'required|numeric|min:0',
      'description' => 'nullable|string',
      'address' => 'nullable|string|max:255',
      'image_paths' => 'nullable|array',
      'image_paths.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
      'remove_image' => 'nullable|in:0,1',
    ]);

    if ($request->input('remove_image') === '1') {
      if ($product->image_paths && is_array($product->image_paths)) {
        foreach ($product->image_paths as $imagePath) {
          if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
          }
        }
      }
      $validated['image_paths'] = null;
    } elseif ($request->hasFile('image_paths')) {
      if ($product->image_paths && is_array($product->image_paths)) {
        foreach ($product->image_paths as $imagePath) {
          if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
          }
        }
      }
      $imagePaths = [];
      foreach ($request->file('image_paths') as $image) {
        $path = $image->store('product_images', 'public');
        $imagePaths[] = $path;
      }
      $validated['image_paths'] = $imagePaths;
    }

    $product->update($validated);

    return redirect()->route('vendor.myproducts')->with('success', 'Produk berhasil diperbarui.');
  }

  public function destroy($id)
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $product = Product::findOrFail($id);

    if ($product->vendor_id !== $user->id) {
      return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    if ($product->image_paths && is_array($product->image_paths)) {
      foreach ($product->image_paths as $imagePath) {
        if (Storage::disk('public')->exists($imagePath)) {
          Storage::disk('public')->delete($imagePath);
        }
      }
    }

    $product->delete();

    return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
  }

  public function show($id)
  {
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