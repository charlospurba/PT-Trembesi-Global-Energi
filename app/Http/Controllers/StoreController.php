<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Rating;

class StoreController extends Controller
{
    public function show($storeName)
    {
        $storeName = urldecode($storeName);

        // Fetch all products from the specific supplier
        $products = Product::where('supplier', $storeName)->paginate(12);
        $totalProducts = Product::where('supplier', $storeName)->count();

        // Fetch vendor based on name (supplier)
        $vendor = User::where('name', $storeName)->first();

        // Create mock store object with vendor info
        $store = (object) [
            'name' => $storeName,
            'profile_picture' => $vendor?->profile_picture,
            'email' => $vendor?->email,
            'phone_number' => $vendor?->phone_number,
            'created_at' => $vendor?->created_at,
            'vendor' => $vendor,
        ];

        // Calculate average rating and total reviews for the store's products
        $ratings = Rating::whereIn('product_id', Product::where('supplier', $storeName)->pluck('id'))
            ->selectRaw('AVG(rating) as average_rating, COUNT(*) as total_reviews')
            ->first();

        $averageRating = $ratings->average_rating ? round($ratings->average_rating, 1) : 0;
        $totalReviews = $ratings->total_reviews ?? 0;

        return view('store.show', compact('store', 'products', 'totalProducts', 'averageRating', 'totalReviews'));
    }

    public function getStoreReviews(Request $request, $storeName)
    {
        $storeName = urldecode($storeName);

        // Calculate average rating and total reviews for the store's products
        $ratings = Rating::whereIn('product_id', Product::where('supplier', $storeName)->pluck('id'))
            ->selectRaw('AVG(rating) as average_rating, COUNT(*) as total_reviews')
            ->first();

        return response()->json([
            'averageRating' => $ratings->average_rating ? round($ratings->average_rating, 1) : 0,
            'totalReviews' => $ratings->total_reviews ?? 0,
        ]);
    }
}