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

  public function materialProducts()
  {
    $products = Product::where('category', 'Material')->get();
    return view('procurement.material', compact('products'));
  }

  public function equipmentProducts()
  {
    $products = Product::where('category', 'Equipment')->get();
    return view('procurement.equipment', compact('products'));
  }

  public function consumablesProducts()
  {
    $products = Product::where('category', 'Consumables')->get();
    return view('procurement.consumables', compact('products'));
  }

  public function electricalProducts()
  {
    $products = Product::where('category', 'Electrical')->get();
    return view('procurement.electrical', compact('products'));
  }

  public function personalProducts()
  {
    $products = Product::where('category', 'Personal')->get();
    return view('procurement.personal', compact('products'));
  }

  public function dashboard()
  {
    $randomMaterials = Product::where('category', 'Material')->inRandomOrder()->limit(6)->get();
    $randomEquipments = Product::where('category', 'Equipment')->inRandomOrder()->limit(6)->get();
    $randomElectricals = Product::where('category', 'Electrical')->inRandomOrder()->limit(6)->get();
    $randomConsumables = Product::where('category', 'Consumables')->inRandomOrder()->limit(6)->get();
    $randomPPEs = Product::where('category', 'Personal')->inRandomOrder()->limit(6)->get();

    return view('procurement.dashboardproc', compact(
      'randomMaterials',
      'randomEquipments',
      'randomElectricals',
      'randomConsumables',
      'randomPPEs'
    ));
  }

}
