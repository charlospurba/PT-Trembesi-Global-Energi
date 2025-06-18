<?php

use App\Http\Controllers\VendorHomeController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

// 🏠 Default route tetap dashboard walaupun belum login
Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', action: [ProductController::class, 'dashboard']);

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
    // 🛍️ Vendor
    Route::get('/dashboard/vendor', [VendorHomeController::class, 'index'])->name('vendor.dashboardvendor');

    // Superadmin & Product Manager
    Route::view('/dashboard/superadmin', 'dashboard.superadmin')->name('dashboard.superadmin');
    Route::view('/dashboard/productmanager', 'productmanager.dashboardpm')->name('dashboard.productmanager');
    Route::view('/productmanager', 'productmanager.addrequest')->name('productmanager.addrequest');

    // 👷 Procurement views
    Route::get('/dashboard/procurement', [ProductController::class, 'dashboard'])->name('procurement.dashboardproc');
    Route::get('/material', [ProductController::class, 'materialProducts'])->name('procurement.material');
    Route::get('/equipment', [ProductController::class, 'equipmentProducts'])->name('procurement.equipment');
    Route::get('/consumables', [ProductController::class, 'consumablesProducts'])->name('procurement.consumables');
    Route::get('/electrical', [ProductController::class, 'electricalProducts'])->name('procurement.electrical');
    Route::get('/personal', [ProductController::class, 'personalProducts'])->name('procurement.personal');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

    // Cart routes
    Route::get('/cart', [CartController::class, 'showCart'])->name('procurement.cart');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/buy-now/{id}', [CartController::class, 'buyNow'])->name('cart.buy-now');
    Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

    // Checkout
    Route::get('/procurement/checkout', [CartController::class, 'checkout'])->name('procurement.checkout');
    Route::post('/procurement/checkout', [CartController::class, 'submitCheckout'])->name('procurement.checkout.submit');

    // Vendor product routes
    Route::get('/myproducts', [VendorProductController::class, 'index'])->name('vendor.myproducts');
    Route::get('/add_product', [VendorProductController::class, 'create'])->name('vendor.add_product');
    Route::post('/add_product', [VendorProductController::class, 'store'])->name('vendor.add_product.store');
    Route::get('/products/{id}/edit', [VendorProductController::class, 'edit'])->name('vendor.edit_product');
    Route::put('/products/{id}', [VendorProductController::class, 'update'])->name('vendor.update_product');
    Route::delete('/products/{id}', [VendorProductController::class, 'destroy'])->name('vendor.destroy_product');
    Route::get('/products/{id}/detail', [VendorProductController::class, 'show'])->name('vendor.product_detail');

    // Vendor view order product routes
    Route::get('/vendor/view', function () {
        return view('vendor.view');
    })->name('vendor.view');
    Route::get('/vendor/myproducts', [VendorProductController::class, 'index'])->name('vendor.vendor_myproducts');
    Route::view('/orders', 'vendor.orders')->name('vendor.orders');
    Route::view('/report', 'vendor.report')->name('vendor.report');
    Route::view('/vendor/view', 'vendor.view')->name('vendor.view');

    //Superadmin

    Route::view('/dashboard/superadmin', 'superadmin.dashboardadm')->name('superadmin.dashboard');
    Route::view('/dashboard/superadmin/add_users', 'superadmin.add_users')->name('superadmin.add_users');
    Route::view('/dashboard/superadmin/request', 'superadmin.request')->name('superadmin.request');

});


// Profile
Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('components.profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');