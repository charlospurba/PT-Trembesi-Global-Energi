<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
  public function create()
  {
    return view('vendor.add_product');
  }

  public function store(Request $request)
  {
    $request->validate([
      'category' => 'required|string|max:255',
      'brand' => 'nullable|string|max:255',
      'supplier' => 'required|string|max:255',
      'name' => 'required|string|max:255',
      'specification' => 'required|string|max:255',
      'unit' => 'required|string|max:255',
      'quantity' => 'required|integer|min:1',
      'price' => 'required|numeric|min:0',
      'description' => 'nullable|string',
      'address' => 'nullable|string',
      'image_paths.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
    ]);

    $product = new Product();
    $product->category = $request->category;
    $product->brand = $request->brand;
    $product->supplier = $request->supplier;
    $product->name = $request->name;
    $product->specification = $request->specification;
    $product->unit = $request->unit;
    $product->quantity = $request->quantity;
    $product->price = $request->price;
    $product->description = $request->description;
    $product->address = $request->address;
    $product->vendor_id = auth()->id();
    $product->save();

    $imageNames = [];

    if ($request->hasFile('image_paths')) {
      foreach ($request->file('image_paths') as $image) {
        if ($image->isValid()) {
          $filename = uniqid() . '.' . $image->getClientOriginalExtension();
          $image->storeAs('image_paths', $filename, 'public');
          $imageNames[] = $filename;
        }
      }
    }

    // Simpan sebagai JSON
    $product->image_paths = $imageNames;
    $product->save();

    return redirect()->route('vendor.add_product')->with('success', 'Product added successfully!');
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
    $products = Product::where('category', 'Electrical Tools')->get();
    return view('procurement.electrical', compact('products'));
  }

  public function personalProducts()
  {
    $products = Product::where('category', 'Personal Protective Equipment')->get();
    return view('procurement.personal', compact('products'));
  }

  public function dashboard(Request $request)
  {
    $randomMaterials = Product::where('category', 'Material')->inRandomOrder()->limit(6)->get();
    $randomEquipments = Product::where('category', 'Equipment')->inRandomOrder()->limit(6)->get();
    $randomElectricals = Product::where('category', 'Electrical Tools')->inRandomOrder()->limit(6)->get();
    $randomConsumables = Product::where('category', 'Consumables')->inRandomOrder()->limit(6)->get();
    $randomPPEs = Product::where('category', 'Personal Protective Equipment')->inRandomOrder()->limit(6)->get();

    $data = compact(
      'randomMaterials',
      'randomEquipments',
      'randomElectricals',
      'randomConsumables',
      'randomPPEs'
    );

    // ✅ Periksa apakah user sudah login
    if (auth()->check()) {
      // Jika user login, arahkan berdasarkan peran
      if (auth()->user()->role === 'procurement') {
        return view('procurement.dashboardproc', $data);
      } else {
        return view('dashboard', $data);
      }
    } else {
      // ✅ Jika belum login, tampilkan dashboard umum (guest)
      return view('dashboard', $data);
    }
  }

  public function show($id)
  {
    $product = Product::findOrFail($id);
    return view('procurement.detail', compact('product'));
  }
}
