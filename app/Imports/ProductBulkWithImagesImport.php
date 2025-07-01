<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductBulkWithImagesImport implements OnEachRow, WithHeadingRow
{
  protected $imageDir;

  public function __construct($imageDir)
  {
    $this->imageDir = $imageDir;
  }

  public function onRow(Row $row)
  {
    $row = $row->toArray();

    try {
      $imageFileName = $row['image_name'] ?? null;
      $storedPath = null;

      // Cari gambar secara rekursif di seluruh folder
      $imageFullPath = $this->findImageRecursively($this->imageDir, $imageFileName);

      if ($imageFileName) {
        $imageFullPath = $this->findImageRecursively($this->imageDir, $imageFileName);
        if ($imageFullPath && file_exists($imageFullPath)) {
          $storedPath = Storage::disk('public')->putFileAs(
            'products',
            new \Illuminate\Http\File($imageFullPath),
            $imageFileName
          );
        } else {
          Log::warning('Image not found in extracted ZIP', [
            'searched' => $imageFileName,
            'dir' => $this->imageDir
          ]);
        }
      }

      Product::create([
        'name' => $row['name'] ?? '',
        'description' => $row['description'] ?? '',
        'price' => $row['price'] ?? 0,
        'quantity' => $row['quantity'] ?? 0,
        'category' => $row['category'] ?? '',
        'supplier' => Auth::user()->name, // isi otomatis
        'brand' => $row['brand'] ?? '',
        'specification' => $row['specification'] ?? '',
        'unit' => $row['unit'] ?? '',
        'address' => $row['address'] ?? '',
        'image_paths' => $storedPath ? [$storedPath] : null,
        'vendor_id' => Auth::id(),
        'status' => 'available',
      ]);

    } catch (\Throwable $e) {
      Log::error('Gagal mengimpor baris', [
        'row' => $row,
        'error' => $e->getMessage(),
      ]);
    }
  }

  protected function findImageRecursively($dir, $filename)
  {
    $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));

    foreach ($rii as $file) {
      if ($file->isFile() && $file->getFilename() === $filename) {
        return $file->getPathname();
      }
    }

    return null;
  }

}
