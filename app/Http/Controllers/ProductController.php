<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

  public function materialProducts(Request $request)
  {
    $query = strtolower($request->input('query'));
    $sort = $request->input('sort');

    $products = Product::where('category', 'material')
      ->when($query, function ($q) use ($query) {
        $q->where(function ($inner) use ($query) {
          $inner->where(DB::raw('LOWER(name)'), 'like', "%$query%")
            ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
            ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
        });
      })
      ->when($sort === 'lowest', function ($q) {
        $q->orderBy('price', 'asc');
      })
      ->when($sort === 'highest', function ($q) {
        $q->orderBy('price', 'desc');
      })
      ->get();

    return view('procurement.material', compact('products', 'query', 'sort'));
  }

  public function equipmentProducts(Request $request)
  {
    $query = strtolower($request->input('query'));
    $sort = $request->input('sort');

    $products = Product::where('category', 'equipment')
      ->when($query, function ($q) use ($query) {
        $q->where(function ($inner) use ($query) {
          $inner->where(DB::raw('LOWER(name)'), 'like', "%$query%")
            ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
            ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
        });
      })
      ->when($sort === 'lowest', function ($q) {
        $q->orderBy('price', 'asc');
      })
      ->when($sort === 'highest', function ($q) {
        $q->orderBy('price', 'desc');
      })
      ->get();

    return view('procurement.equipment', compact('products', 'query', 'sort'));
  }

  public function consumablesProducts(Request $request)
  {
    $query = strtolower($request->input('query'));
    $sort = $request->input('sort');

    $products = Product::where('category', 'consumables')
      ->when($query, function ($q) use ($query) {
        $q->where(function ($inner) use ($query) {
          $inner->where(DB::raw('LOWER(name)'), 'like', "%$query%")
            ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
            ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
        });
      })
      ->when($sort === 'lowest', function ($q) {
        $q->orderBy('price', 'asc');
      })
      ->when($sort === 'highest', function ($q) {
        $q->orderBy('price', 'desc');
      })
      ->get();

    return view('procurement.consumables', compact('products', 'query', 'sort'));
  }

  public function electricalProducts(Request $request)
  {
    $query = strtolower($request->input('query'));
    $sort = $request->input('sort');

    $products = Product::where('category', 'electrical tools')
      ->when($query, function ($q) use ($query) {
        $q->where(function ($inner) use ($query) {
          $inner->where(DB::raw('LOWER(name)'), 'like', "%$query%")
            ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
            ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
        });
      })
      ->when($sort === 'lowest', function ($q) {
        $q->orderBy('price', 'asc');
      })
      ->when($sort === 'highest', function ($q) {
        $q->orderBy('price', 'desc');
      })
      ->get();

    return view('procurement.electrical', compact('products', 'query', 'sort'));
  }

  public function personalProducts(Request $request)
  {
    $query = strtolower($request->input('query'));
    $sort = $request->input('sort');

    $products = Product::where('category', 'personal protective equipment')
      ->when($query, function ($q) use ($query) {
        $q->where(function ($inner) use ($query) {
          $inner->where(DB::raw('LOWER(name)'), 'like', "%$query%")
            ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
            ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
        });
      })
      ->when($sort === 'lowest', function ($q) {
        $q->orderBy('price', 'asc');
      })
      ->when($sort === 'highest', function ($q) {
        $q->orderBy('price', 'desc');
      })
      ->get();

    return view('procurement.personal', compact('products', 'query', 'sort'));
  }

  public function dashboard(Request $request)
  {
    $query = $request->query('query');

    if ($query) {
      $searchResults = Product::where('name', 'like', "%$query%")
        ->orWhere('supplier', 'like', "%$query%")
        ->orWhere('address', 'like', "%$query%")
        ->get();

      return view('dashboard', compact('searchResults', 'query'));
    }

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

    if (Auth::check() && Auth::user()->role === 'procurement') {
      return view('procurement.dashboardproc', $data);
    }

    return view('dashboard', $data);
  }

  public function search(Request $request)
  {
    $query = strtolower($request->input('query'));
    $category = $request->input('category');

    $results = Product::query()
      ->when($category, function ($q) use ($category) {
        $categoryMap = [
          'material' => 'material',
          'electrical' => 'electrical tools',
          'consumables' => 'consumables',
          'equipment' => 'equipment',
          'personal' => 'personal protective equipment',
        ];
        if (isset($categoryMap[$category])) {
          $q->where('category', $categoryMap[$category]);
        }
      })
      ->where(function ($q) use ($query) {
        $q->where(DB::raw('LOWER(name)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
      })
      ->get();

    if ($category) {
      $viewMap = [
        'material' => 'procurement.material',
        'electrical' => 'procurement.electrical',
        'consumables' => 'procurement.consumables',
        'equipment' => 'procurement.equipment',
        'personal' => 'procurement.personal',
      ];
      if (isset($viewMap[$category])) {
        return view($viewMap[$category], [
          'products' => $results,
          'query' => $query,
        ]);
      }
    }

    return view('search-result', [
      'results' => $results,
      'query' => $query,
    ]);
  }

  public function show($id)
  {
    try {
      $product = Product::with('ratings')->findOrFail($id);
      $soldQuantity = OrderItem::where('product_id', $id)->sum('quantity');

      return view('procurement.detail', compact('product', 'soldQuantity'));
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      Log::error('Product not found: ' . $id);
      return redirect()->route('procurement.dashboardproc')->withErrors(['error' => 'Product not found.']);
    } catch (\Exception $e) {
      Log::error('Product Show Error: ' . $e->getMessage(), [
        'product_id' => $id,
        'trace' => $e->getTraceAsString()
      ]);
      return redirect()->route('procurement.dashboardproc')->withErrors(['error' => 'Failed to load product details.']);
    }
  }

  public function searchMaterial(Request $request)
  {
    $query = strtolower($request->input('query'));

    $products = Product::where('category', 'material')
      ->where(function ($q) use ($query) {
        $q->where(DB::raw('LOWER(name)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
      })->get();

    return view('procurement.material', compact('products', 'query'));
  }

  public function searchEquipment(Request $request)
  {
    $query = strtolower($request->input('query'));

    $products = Product::where('category', 'equipment')
      ->where(function ($q) use ($query) {
        $q->where(DB::raw('LOWER(name)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
      })->get();

    return view('procurement.equipment', compact('products', 'query'));
  }

  public function searchElectrical(Request $request)
  {
    $query = strtolower($request->input('query'));

    $products = Product::where('category', 'electrical tools')
      ->where(function ($q) use ($query) {
        $q->where(DB::raw('LOWER(name)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
      })->get();

    return view('procurement.electrical', compact('products', 'query'));
  }

  public function searchConsumables(Request $request)
  {
    $query = strtolower($request->input('query'));

    $products = Product::where('category', 'consumables')
      ->where(function ($q) use ($query) {
        $q->where(DB::raw('LOWER(name)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
      })->get();

    return view('procurement.consumables', compact('products', 'query'));
  }

  public function searchPersonal(Request $request)
  {
    $query = strtolower($request->input('query'));

    $products = Product::where('category', 'personal protective equipment')
      ->where(function ($q) use ($query) {
        $q->where(DB::raw('LOWER(name)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(supplier)'), 'like', "%$query%")
          ->orWhere(DB::raw('LOWER(address)'), 'like', "%$query%");
      })->get();

    return view('procurement.personal', compact('products', 'query'));
  }
}