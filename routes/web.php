<?php

use App\Http\Controllers\VendorHomeController;
use App\Http\Controllers\VendorProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProcurementHomeController;
use App\Http\Controllers\ProfileController;

// 🏠 Default route tetap dashboard walaupun belum login
Route::get('/', fn() => view('dashboard'))->name('dashboard');
Route::get('/dashboard', fn() => view('dashboard'));

// 📄 Optional route ke login/signup via tombol (view langsung)
Route::view('/signin', 'auth.login')->name('signin');
Route::view('/signup', 'auth.register')->name('auth.register');
Route::view('/signup/form', 'auth.register_form')->name('auth.register_form');

// 🔐 Login & Register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('/register/detail', [RegisterController::class, 'showDetailForm'])->name('auth.register_detail');
Route::post('/register/detail', [RegisterController::class, 'submitDetailForm'])->name('auth.register_detail_submit');
Route::get('/register-detail', function () {
    return view('auth.register_form_detail');
})->name('register.step2');

// ✅ Setelah login, redirect berdasarkan role ke halaman dashboard masing-masing
Route::middleware(['auth'])->group(function () {
    // 👷 Procurement
    Route::get('/dashboard/procurement', [ProcurementHomeController::class, 'index'])->name('procurement.dashboardproc');

    // 🛍️ Vendor
    Route::get('/dashboard/vendor', [VendorHomeController::class, 'index'])->name('vendor.dashboardvendor');

    // Superadmin & Product Manager (belum dibuat)
    Route::view('/dashboard/superadmin', 'dashboard.superadmin')->name('dashboard.superadmin');
    Route::view('/dashboard/productmanager', 'dashboard.productmanager')->name('dashboard.productmanager');

    // Procurement views
    Route::view('/material', 'procurement.material')->name('procurement.material');
    Route::view('/equipment', 'procurement.equipment')->name('procurement.equipment');
    Route::view('/electrical', 'procurement.electrical')->name('procurement.electrical');
    Route::view('/consumables', 'procurement.consumables')->name('procurement.consumables');
    Route::view('/personal', 'procurement.personal')->name('procurement.personal');
    Route::view('/detail', 'procurement.detail')->name('procurement.detail');

    // Cart
    Route::get('/cart', function () {
        $cartItems = session()->get('cart', []);
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        return view('procurement.cart', compact('cartItems', 'totalPrice'));
    })->name('procurement.cart');

    // Vendor product routes
    Route::get('/myproducts', [VendorProductController::class, 'index'])->name('vendor.myproducts');
    Route::get('/add_product', [VendorProductController::class, 'create'])->name('vendor.add_product');
    Route::post('/add_product', [VendorProductController::class, 'store'])->name('vendor.add_product.store');
    Route::get('/products/{id}/edit', [VendorProductController::class, 'edit'])->name('vendor.edit_product');
    Route::put('/products/{id}', [VendorProductController::class, 'update'])->name('vendor.update_product');
    Route::delete('/products/{id}', [VendorProductController::class, 'destroy'])->name('vendor.destroy_product');

    // Alias untuk vendor.myproducts
    Route::get('/vendor/myproducts', [VendorProductController::class, 'index'])->name('vendor.vendor_myproducts');

    Route::view('/orders', 'vendor.orders')->name('vendor.orders');
    Route::view('/report', 'vendor.report')->name('vendor.report');
});

// Profile
Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('components.profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');