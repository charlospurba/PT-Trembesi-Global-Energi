<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VendorHomeController extends Controller
{
    public function index()
    {
        $vendorId = Auth::id();
        
        // Existing data
        $productCount = Product::where('vendor_id', $vendorId)->count();
        
        $randomMaterials = Product::where('vendor_id', $vendorId)
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        // New dashboard statistics
        $stats = $this->getDashboardStats($vendorId);
        
        return view('vendor.dashboardvendor', compact('productCount', 'randomMaterials', 'stats'));
    }
    
    private function getDashboardStats($vendorId)
    {
        // Orders In (Awaiting Shipment)
        $ordersIn = Order::whereHas('orderItems.product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })
        ->where('status', 'Awaiting Shipment')
        ->count();
        
        // Orders Processed (Shipped + Completed)
        $ordersProcessed = Order::whereHas('orderItems.product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })
        ->whereIn('status', ['Shipped', 'Completed'])
        ->count();
        
        // Total Sales (Completed orders only)
        $totalSales = Order::whereHas('orderItems.product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })
        ->where('status', 'Completed')
        ->sum('total_price');
        
        return [
            'orders_in' => $ordersIn,
            'orders_processed' => $ordersProcessed,
            'total_sales' => $totalSales,
        ];
    }
}