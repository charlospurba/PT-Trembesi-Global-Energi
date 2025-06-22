<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'category' => 'required|string',
        'supplier' => 'required|string',
        'image_paths' => 'nullable|array',
      ]);

      $product = Product::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'quantity' => $validated['quantity'],
        'category' => $validated['category'],
        'supplier' => $validated['supplier'],
        'vendor_id' => Auth::id(),
        'image_paths' => $validated['image_paths'] ?? [],
      ]);

      Log::info('Product Created', ['product_id' => $product->id, 'vendor_id' => Auth::id()]);

      return redirect()->route('vendor.myproducts')->with('success', 'Product added successfully!');
    } catch (\Exception $e) {
      Log::error('Product Creation Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
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
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'category' => 'required|string',
        'supplier' => 'required|string',
        'image_paths' => 'nullable|array',
      ]);

      $product->update([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'quantity' => $validated['quantity'],
        'category' => $validated['category'],
        'supplier' => $validated['supplier'],
        'image_paths' => $validated['image_paths'] ?? [],
      ]);

      return redirect()->route('vendor.myproducts')->with('success', 'Product updated successfully!');
    } catch (\Exception $e) {
      Log::error('Product Update Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return back()->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()]);
    }
  }

  public function destroy($id)
  {
    try {
      $product = Product::where('id', $id)->where('vendor_id', Auth::id())->firstOrFail();
      $product->delete();
      return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
    } catch (\Exception $e) {
      Log::error('Product Deletion Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return response()->json(['success' => false, 'message' => 'Failed to delete product: ' . $e->getMessage()], 500);
    }
  }

  public function show($id)
  {
    $product = Product::where('id', $id)->where('vendor_id', Auth::id())->firstOrFail();
    return view('vendor.product_detail', compact('product'));
  }
}