<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User; // Assuming suppliers are stored in users table

class StoreController extends Controller
{
    public function show($storeName)
    {
        // Get store/supplier information by name
        // Since you're using supplier names directly, we'll work with that
        $storeName = urldecode($storeName);
        
        // Get all products from this store/supplier
        $products = Product::where('supplier', $storeName)->paginate(12);
        
        // Calculate store statistics
        $totalProducts = Product::where('supplier', $storeName)->count();
        
        // Create a mock store object since we don't have a dedicated stores table
        $store = (object) [
            'name' => $storeName,
            'profile_picture' => null,
            'email' => null,
            'phone_number' => null,
            'created_at' => null
        ];
        
        // You can add more statistics like average rating, total sales, etc.
        $averageRating = 5; // Placeholder - calculate from actual ratings
        $totalReviews = 15; // Placeholder - count from actual reviews
        
        return view('store.show', compact('store', 'products', 'totalProducts', 'averageRating', 'totalReviews'));
    }
}