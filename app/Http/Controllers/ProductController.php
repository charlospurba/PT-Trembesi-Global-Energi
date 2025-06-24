<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  public function create()
  {
    return view('vendor.add_product');
  }

  public function store(Request $request)
  {
    try {
      Log::info('Starting product creation', ['user_id' => Auth::id()]);

      $validated = $request->validate([
        'category' => 'required|string|max:255|in:material,equipment,electrical tools,consumables,personal protective equipment',
        'brand' => 'nullable|string|max:255',
        'supplier' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'specification' => 'nullable|string|max:255',
        'unit' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'address' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
      ]);

      $imagePaths = [];
      if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
          if ($image->isValid()) {
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $filename, 'public');
            $imagePaths[] = $path;
            Log::info('Image uploaded', ['path' => $path]);
          } else {
            Log::warning('Invalid image file detected', ['file' => $image->getClientOriginalName()]);
          }
        }
      }

      $product = Product::create([
        'category' => $validated['category'],
        'brand' => $validated['brand'],
        'supplier' => $validated['supplier'],
        'name' => $validated['name'],
        'specification' => $validated['specification'],
        'unit' => $validated['unit'],
        'quantity' => $validated['quantity'],
        'price' => $validated['price'],
        'description' => $validated['description'],
        'address' => $validated['address'],
        'image_paths' => !empty($imagePaths) ? $imagePaths : null,
        'vendor_id' => Auth::id(),
      ]);

      Log::info('Product created', ['product_id' => $product->id, 'vendor_id' => Auth::id(), 'image_paths' => $product->image_paths]);

      return redirect()->route('vendor.myproducts')->with('success', 'Product added successfully!');
    } catch (\Exception $e) {
      Log::error('Product creation error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
      return back()->withErrors(['error' => 'Failed to add product: ' . $e->getMessage()]);
    }
  }

  public function index()
  {
    $products = Product::where('vendor_id', Auth::id())->get();
    return view('vendor.myproducts', compact('products'));
  }

  public function materialProducts()
  {
    $products = Product::where('category', 'material')->get();
    return view('procurement.material', compact('products'));
  }

  public function equipmentProducts()
  {
    $products = Product::where('category', 'equipment')->get();
    return view('procurement.equipment', compact('products'));
  }

  public function consumablesProducts()
  {
    $products = Product::where('category', 'consumables')->get();
    return view('procurement.consumables', compact('products'));
  }

  public function electricalProducts()
  {
    $products = Product::where('category', 'electrical tools')->get();
    return view('procurement.electrical', compact('products'));
  }

  public function personalProducts()
  {
    $products = Product::where('category', 'personal protective equipment')->get();
    return view('procurement.personal', compact('products'));
  }

  public function dashboard(Request $request)
  {
    $randomMaterials = Product::where('category', 'material')->inRandomOrder()->limit(6)->get();
    $randomEquipments = Product::where('category', 'equipment')->inRandomOrder()->limit(6)->get();
    $randomElectricals = Product::where('category', 'electrical tools')->inRandomOrder()->limit(6)->get();
    $randomConsumables = Product::where('category', 'consumables')->inRandomOrder()->limit(6)->get();
    $randomPPEs = Product::where('category', 'personal protective equipment')->inRandomOrder()->limit(6)->get();

    $data = compact(
      'randomMaterials',
      'randomEquipments',
      'randomElectricals',
      'randomConsumables',
      'randomPPEs'
    );

    if (auth()->check()) {
      if (auth()->user()->role === 'procurement') {
        return view('procurement.dashboardproc', $data);
      } else {
        return view('dashboard', $data);
      }
    } else {
      return view('dashboard', $data);
    }
  }

  public function show($id)
  {
    $product = Product::findOrFail($id);
    return view('procurement.detail', compact('product'));
  }
}
