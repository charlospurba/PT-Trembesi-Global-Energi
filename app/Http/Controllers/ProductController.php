<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  public function create()
  {
    return view('vendor.add_product');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'category' => 'required',
      'brand' => 'nullable|string',
      'supplier' => 'required|string',
      'name' => 'required|string',
      'specification' => 'required',
      'custom_spec' => 'nullable|string',
      'quantity' => 'required|integer|min:1',
      'description' => 'nullable|string',
      'address' => 'nullable|string',
      'price' => 'required|integer|min:0',
      'productImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($request->hasFile('productImage')) {
      $path = $request->file('productImage')->store('public/products');
      $validated['image_path'] = Storage::url($path);
    }

    Product::create($validated);

    return redirect()->route('vendor.myproducts')->with('success', 'Product added successfully!');
  }

  public function index()
  {
    $products = Product::all();
    return view('vendor.vendor_myproducts', compact('products'));
  }
}
