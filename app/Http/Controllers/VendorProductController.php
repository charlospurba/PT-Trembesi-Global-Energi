<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Imports\ProductsImport;
use App\Imports\ProductBulkWithImagesImport;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class VendorProductController extends Controller
{
  public function index()
  {
    $products = Product::where('vendor_id', Auth::id())->orderBy('created_at', 'DESC')->get();
    return view('vendor.myproducts', compact('products'));
  }

  public function create()
  {
    return view('vendor.add_product');
  }

  public function store(Request $request)
  {
    try {
      Log::info('Starting product creation', [
        'user_id' => Auth::id(),
        'files_count' => $request->hasFile('images') ? count($request->file('images')) : 0,
        'files_details' => $request->hasFile('images') ? collect($request->file('images'))->map(function ($file) {
          return [
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
          ];
        })->toArray() : [],
      ]);

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
        foreach ($request->file('images') as $index => $image) {
          if ($image->isValid()) {
            $path = $image->store('products', 'public');
            $imagePaths[] = $path;
            Log::info('Image uploaded', [
              'index' => $index,
              'path' => $path,
              'filename' => $image->getClientOriginalName(),
              'size' => $image->getSize(),
              'mime' => $image->getMimeType(),
            ]);
          } else {
            Log::warning('Invalid image file', [
              'index' => $index,
              'filename' => $image->getClientOriginalName(),
              'error' => $image->getErrorMessage(),
              'size' => $image->getSize(),
              'mime' => $image->getMimeType(),
            ]);
          }
        }
      }

      if (empty($imagePaths) && $request->hasFile('images')) {
        Log::warning('No valid images were saved', [
          'files_submitted' => count($request->file('images')),
        ]);
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

      Log::info('Product created', [
        'product_id' => $product->id,
        'vendor_id' => Auth::id(),
        'image_paths' => $product->image_paths,
      ]);

      return redirect()->route('vendor.myproducts')->with('success', 'Product added successfully!');
    } catch (ValidationException $e) {
      Log::error('Validation error during product creation', [
        'errors' => $e->errors(),
        'input' => $request->all(),
      ]);
      return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
      Log::error('Product creation error: ' . $e->getMessage(), [
        'trace' => $e->getTraceAsString(),
      ]);
      return back()->withErrors(['error' => 'Failed to add product: ' . $e->getMessage()]);
    }
  }

  public function uploadBulkWithImages(Request $request)
  {
    $request->validate([
      'excel_file' => 'required|mimes:xlsx,xls',
      'zip_file' => 'required|mimes:zip',
    ]);

    try {
      $zipFile = $request->file('zip_file');
      $realZipPath = $zipFile->getRealPath();
      $extractPath = storage_path('app/temp_unzipped/' . uniqid());

      mkdir($extractPath, 0755, true);

      $zip = new ZipArchive;
      if ($zip->open($realZipPath) === true) {
        $zip->extractTo($extractPath);
        $zip->close();
      } else {
        return back()->withErrors(['zip_file' => 'ZIP tidak bisa dibuka.']);
      }

      Excel::import(new ProductBulkWithImagesImport($extractPath), $request->file('excel_file'));

      File::deleteDirectory($extractPath);

      return back()->with('success', 'Produk berhasil diunggah secara massal!');
    } catch (\Exception $e) {
      Log::error('Upload bulk gagal', ['msg' => $e->getMessage()]);
      return back()->withErrors(['excel_file' => 'Gagal unggah: ' . $e->getMessage()]);
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
      Log::info('Starting product update', [
        'product_id' => $id,
        'user_id' => Auth::id(),
        'files_count' => $request->hasFile('images') ? count($request->file('images')) : 0,
        'files_details' => $request->hasFile('images') ? collect($request->file('images'))->map(function ($file) {
          return [
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
          ];
        })->toArray() : [],
      ]);

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
        'existing_images.*' => 'nullable|string',
        'remove_image_indices' => 'nullable|string',
      ]);

      $imagePaths = [];
      $existingImages = $request->input('existing_images', []);
      $removeIndices = $request->input('remove_image_indices') ? array_map('intval', explode(',', $request->input('remove_image_indices'))) : [];

      if ($request->hasFile('images')) {
        if ($product->image_paths && is_array($product->image_paths)) {
          foreach ($product->image_paths as $oldImage) {
            Storage::disk('public')->delete($oldImage);
            Log::info('Old image deleted', ['path' => $oldImage]);
          }
        }
        foreach ($request->file('images') as $index => $image) {
          if ($image->isValid()) {
            $path = $image->store('products', 'public');
            $imagePaths[] = $path;
            Log::info('New image uploaded', [
              'index' => $index,
              'path' => $path,
              'filename' => $image->getClientOriginalName(),
              'size' => $image->getSize(),
              'mime' => $image->getMimeType(),
            ]);
          } else {
            Log::warning('Invalid image file', [
              'index' => $index,
              'filename' => $image->getClientOriginalName(),
              'error' => $image->getErrorMessage(),
              'size' => $image->getSize(),
              'mime' => $image->getMimeType(),
            ]);
          }
        }
      } else {
        if ($product->image_paths && is_array($product->image_paths)) {
          foreach ($product->image_paths as $index => $path) {
            if (!in_array($index, $removeIndices) && in_array($path, $existingImages)) {
              $imagePaths[] = $path;
            } else {
              Storage::disk('public')->delete($path);
              Log::info('Removed image deleted', ['path' => $path]);
            }
          }
        }
      }

      if (empty($imagePaths) && $request->hasFile('images')) {
        Log::warning('No valid images were saved', [
          'files_submitted' => count($request->file('images')),
        ]);
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

      Log::info('Product updated', [
        'product_id' => $id,
        'vendor_id' => Auth::id(),
        'image_paths' => $product->image_paths,
      ]);

      return redirect()->route('vendor.myproducts')->with('success', 'Product updated successfully!');
    } catch (ValidationException $e) {
      Log::error('Validation error during product update', [
        'errors' => $e->errors(),
        'input' => $request->all(),
      ]);
      return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
      Log::error('Product update error: ' . $e->getMessage(), [
        'trace' => $e->getTraceAsString(),
      ]);
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
      Log::error('Product deletion error: ' . $e->getMessage(), [
        'trace' => $e->getTraceAsString(),
      ]);
      return response()->json(['success' => false, 'message' => 'Failed to delete product: ' . $e->getMessage()], 500);
    }
  }

  public function show($id)
  {
    $product = Product::where('id', $id)->where('vendor_id', Auth::id())->firstOrFail();
    return view('vendor.product_detail', compact('product'));
  }
}