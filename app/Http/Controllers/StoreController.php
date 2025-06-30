<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User; // Assuming suppliers are stored in users table

class StoreController extends Controller
{
    public function show($storeName)
    {
        $storeName = urldecode($storeName);

        // Ambil semua produk dari supplier tertentu
        $products = Product::where('supplier', $storeName)->paginate(12);
        $totalProducts = Product::where('supplier', $storeName)->count();

        // Cari user/vendor berdasarkan nama (supplier)
        $vendor = User::where('name', $storeName)->first();

        // Buat objek store (mock) + tambahkan vendor info
        $store = (object) [
            'name' => $storeName,
            'profile_picture' => $vendor?->profile_picture,
            'email' => $vendor?->email,
            'phone_number' => $vendor?->phone_number,
            'created_at' => $vendor?->created_at,
            'vendor' => $vendor, // <- agar bisa akses di Blade sebagai $store->vendor
        ];

        // Statistik rating (placeholder)
        $averageRating = 5;
        $totalReviews = 15;

        return view('store.show', compact('store', 'products', 'totalProducts', 'averageRating', 'totalReviews'));
    }
}