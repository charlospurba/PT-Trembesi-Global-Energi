<?php

use App\Http\Controllers\VendorHomeController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileVendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserManagementController;

// 🏠 Default Routes
Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard.home');

// 📄 Authentication Views
Route::view('/signin', 'auth.login')->name('signin');
Route::view('/signup', 'auth.register')->name('auth.register');
Route::view('/signup/form', 'auth.register_form')->name('auth.register_form');

// 🔐 Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('/register/detail', [RegisterController::class, 'showDetailForm'])->name('auth.register_detail');
Route::post('/register/detail', [RegisterController::class, 'submitDetailForm'])->name('auth.register_detail_submit');
Route::get('/register-detail', function () {
    return view('auth.register_form_detail');
})->name('register.step2');

// ✅ Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Superadmin & Product Manager Routes
    Route::get('/dashboard/superadmin', [UserManagementController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::view('/dashboard/superadmin/add_users', 'superadmin.add_users')->name('superadmin.add_users');
    Route::view('/dashboard/superadmin/request', 'superadmin.request')->name('superadmin.request');
    Route::get('/superadmin/users/add', [UserManagementController::class, 'create'])->name('superadmin.users.create');
    Route::post('/superadmin/users/store', [UserManagementController::class, 'store'])->name('superadmin.users.store');
    Route::view('/superadmin/view-detail', 'superadmin.view_detail')->name('superadmin.view_detail');

    Route::view('/dashboard/productmanager', 'productmanager.dashboardpm')->name('dashboard.productmanager');
    Route::view('/productmanager/addrequest', 'productmanager.addrequest')->name('productmanager.addrequest');

    // Procurement Routes
    Route::get('/dashboard/procurement', [ProductController::class, 'dashboard'])->name('procurement.dashboardproc');
    Route::get('/material', [ProductController::class, 'materialProducts'])->name('procurement.material');
    Route::get('/equipment', [ProductController::class, 'equipmentProducts'])->name('procurement.equipment');
    Route::get('/consumables', [ProductController::class, 'consumablesProducts'])->name('procurement.consumables');
    Route::get('/electrical', [ProductController::class, 'electricalProducts'])->name('procurement.electrical');
    Route::get('/personal', [ProductController::class, 'personalProducts'])->name('procurement.personal');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'showCart'])->name('procurement.cart');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/buy-now/{id}', [CartController::class, 'buyNow'])->name('cart.buy-now');
    Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

    // Checkout Routes
    Route::match(['get', 'post'], '/procurement/checkout', [CheckoutController::class, 'checkout'])->name('procurement.checkout');
    Route::post('/procurement/checkout/submit', [CheckoutController::class, 'submitCheckout'])->name('procurement.checkout.submit');
    Route::post('/checkout/e-billing', [CheckoutController::class, 'generateEBilling'])->name('checkout.e-billing');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Vendor Routes
    Route::get('/dashboard/vendor', [VendorHomeController::class, 'index'])->name('vendor.dashboardvendor');
    Route::get('/myproducts', [VendorProductController::class, 'index'])->name('vendor.myproducts');
    Route::get('/add_product', [VendorProductController::class, 'create'])->name('vendor.add_product');
    Route::post('/add_product', [VendorProductController::class, 'store'])->name('vendor.store_product');
    Route::get('/products/{id}/edit', [VendorProductController::class, 'edit'])->name('vendor.edit_product');
    Route::put('/products/{id}', [VendorProductController::class, 'update'])->name('vendor.update_product');
    Route::delete('/products/{id}', [VendorProductController::class, 'destroy'])->name('vendor.destroy_product');
    Route::get('/products/{id}/detail', [VendorProductController::class, 'show'])->name('vendor.product_detail');

    // Vendor Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('vendor.orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('vendor.order_detail');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('vendor.order_update_status');

    // Profile Routes
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('components.profile');
    Route::get('/dashboard/profilevendor', [ProfileVendorController::class, 'edit'])->name('components.profilevendor');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
