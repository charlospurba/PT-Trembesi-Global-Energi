<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VendorHomeController extends Controller
{
    public function index()
    {
        $productCount = Product::where('vendor_id', Auth::id())->count();

        $randomMaterials = Product::where('vendor_id', Auth::id())
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('vendor.dashboardvendor', compact('productCount', 'randomMaterials'));
    }
}
