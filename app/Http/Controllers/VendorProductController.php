<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VendorProductController extends Controller
{
  public function index()
  {
    $products = Product::where('vendor_id', Auth::id())->get();
    return view('vendor.myproducts', compact('products'));
  }

  public function create()
  {
    return view('vendor.add_product');
  }

  public function store(Request $request)
  {
    try {
      Log::info('Starting product creation', ['user_id' => Auth::id()]);

      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'category' => 'required|string|max:255|in:material,equipment,electrical tools,consumables,personal protective equipment',
        'supplier' => 'required|string|max:255',
        'brand' => 'nullable|string|max:255',
        'specification' => 'nullable|string|max:500',
        'unit' => 'required|string|max:50',
        'address' => 'nullable|string|max:500',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);

      $imagePaths = [];
      if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
          if ($image->isValid()) {
            $path = $image->store('products', 'public');
            $imagePaths[] = $path;
            Log::info('Image uploaded', ['path' => $path]);
          } else {
            Log::warning('Invalid image file detected', ['file' => $image->getClientOriginalName()]);
          }
        }
      }

      $product = Product::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'quantity' => $validated['quantity'],
        'category' => $validated['category'],
        'supplier' => $validated['supplier'],
        'brand' => $validated['brand'],
        'specification' => $validated['specification'],
        'unit' => $validated['unit'],
        'address' => $validated['address'],
        'image_paths' => !empty($imagePaths) ? $imagePaths : null,
        'vendor_id' => Auth::id(),
        'status' => 'available',
      ]);

      Log::info('Product created', ['product_id' => $product->id, 'vendor_id' => Auth::id(), 'image_paths' => $product->image_paths]);

      return redirect()->route('vendor.myproducts')->with('success', 'Product added successfully!');
    } catch (\Exception $e) {
      Log::error('Product creation error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return back()->withErrors(['error' => 'Failed to add product: ' . $e->getMessage()]);
    }
  }

  public function edit($id)
  {
    $product = Product::where('id', $id)->where('vendor_id', Auth::id())->firstOrFail();
    return view('vendor.edit_product', compact('product'));
  }

  public function update(Request $request, $id)
  {
    try {
      $product = Product::where('id', $id)->where('vendor_id', Auth::id())->firstOrFail();

      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'category' => 'required|string|max:255|in:material,equipment,electrical tools,consumables,personal protective equipment',
        'supplier' => 'required|string|max:255',
        'brand' => 'nullable|string|max:255',
        'specification' => 'nullable|string|max:500',
        'unit' => 'required|string|max:50',
        'address' => 'nullable|string|max:500',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);

      $imagePaths = $product->image_paths ?? [];
      if ($request->hasFile('images')) {
        // Delete old images
        if (!empty($imagePaths)) {
          foreach ($imagePaths as $oldImage) {
            Storage::disk('public')->delete($oldImage);
          }
        }
        $imagePaths = [];
        foreach ($request->file('images') as $image) {
          if ($image->isValid()) {
            $path = $image->store('products', 'public');
            $imagePaths[] = $path;
            Log::info('Image uploaded', ['path' => $path]);
          } else {
            Log::warning('Invalid image file detected', ['file' => $image->getClientOriginalName()]);
          }
        }
      }

      $product->update([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'quantity' => $validated['quantity'],
        'category' => $validated['category'],
        'supplier' => $validated['supplier'],
        'brand' => $validated['brand'],
        'specification' => $validated['specification'],
        'unit' => $validated['unit'],
        'address' => $validated['address'],
        'image_paths' => !empty($imagePaths) ? $imagePaths : null,
      ]);

      Log::info('Product updated', ['product_id' => $id, 'vendor_id' => Auth::id(), 'image_paths' => $product->image_paths]);

      return redirect()->route('vendor.myproducts')->with('success', 'Product updated successfully!');
    } catch (\Exception $e) {
      Log::error('Product update error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return back()->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()]);
    }
  }

  public function destroy($id)
  {
    try {
      $product = Product::where('id', $id)->where('vendor_id', Auth::id())->firstOrFail();
      if ($product->image_paths) {
        foreach ($product->image_paths as $image) {
          Storage::disk('public')->delete($image);
        }
      }
      $product->delete();
      return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
    } catch (\Exception $e) {
      Log::error('Product deletion error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json(['success' => false, 'message' => 'Failed to delete product: ' . $e->getMessage()], 500);
    }
  }

  public function show($id)
  {
    $product = Product::where('id', $id)->where('vendor_id', Auth::id())->firstOrFail();
    return view('vendor.product_detail', compact('product'));
  }
}
