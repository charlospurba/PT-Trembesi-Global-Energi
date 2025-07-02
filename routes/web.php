<?php

use App\Http\Controllers\VendorHomeController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileVendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\VendorApprovalController;
use Illuminate\Support\Facades\Route;

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

// Gunakan ini sebagai route form detail (jika ingin split view)
Route::get('/register-detail', function () {
    return view('auth.register_form_detail');
})->name('register.step2');

// Jika form step 1 dan 2 digabung (seperti yang kamu kirim sebelumnya)
Route::post('/register-detail', [RegisterController::class, 'register'])->name('auth.register_detail_submit');

// ✅ Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Superadmin & Product Manager Routes
    // Superadmin Dashboard
    Route::get('/dashboard/superadmin', [UserManagementController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/dashboard/superadmin/request', [VendorApprovalController::class, 'index'])->name('superadmin.request');
    Route::view('/dashboard/superadmin/add_users', 'superadmin.add_users')->name('superadmin.add_users');

    // Manajemen User Superadmin
    Route::get('/superadmin/users/add', [UserManagementController::class, 'create'])->name('superadmin.users.create');
    Route::post('/superadmin/users/store', [UserManagementController::class, 'store'])->name('superadmin.users.store');
    Route::get('/superadmin/users/edit/{id}', [UserManagementController::class, 'edit'])->name('superadmin.edit');
    Route::post('/superadmin/users/update/{id}', [UserManagementController::class, 'update'])->name('superadmin.users.update');
    Route::delete('/superadmin/users/{id}', [UserManagementController::class, 'destroy'])->name('superadmin.users.destroy');

    // Approval Vendor
    Route::prefix('superadmin')->group(function () {
        Route::get('/vendor-requests', [VendorApprovalController::class, 'index'])->name('superadmin.vendor.requests');
        Route::get('/vendor-requests/{id}', [VendorApprovalController::class, 'show'])->name('superadmin.vendor.detail');
        Route::post('/vendor-requests/{id}/accept', [VendorApprovalController::class, 'accept'])->name('superadmin.vendor.accept');
        Route::post('/vendor-requests/{id}/reject', [VendorApprovalController::class, 'reject'])->name('superadmin.vendor.reject');
    });

    // Product Manager Routes
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

    // Notes Route
    Route::get('/procurement/notes', function () {
        return view('procurement.notes');
    })->name('procurement.notes');

    Route::get('/procurement/detailnote', function () {
        return view('procurement.detailnote');
    })->name('procurement.detailnote');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'showCart'])->name('procurement.cart');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/buy-now/{id}', [CartController::class, 'buyNow'])->name('cart.buy-now');
    Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    Route::post('/cart/bid/{productId}', [CartController::class, 'submitBid'])->name('cart.bid');

    // Checkout Routes
    Route::match(['get', 'post'], '/procurement/checkout', [CheckoutController::class, 'checkout'])->name('procurement.checkout');
    Route::post('/procurement/checkout/submit', [CheckoutController::class, 'submitCheckout'])->name('procurement.checkout.submit');
    Route::get('/e-billing/view/{notification}', [CheckoutController::class, 'viewEBilling'])->name('ebilling.view');
    Route::post('/checkout/e-billing', [CheckoutController::class, 'generateEBilling'])->name('checkout.e-billing');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read_all');

    // Vendor Routes
    Route::get('/dashboard/vendor', [VendorHomeController::class, 'index'])->name('vendor.dashboardvendor');
    Route::get('/myproducts', [VendorProductController::class, 'index'])->name('vendor.myproducts');
    Route::get('/add_product', [VendorProductController::class, 'create'])->name('vendor.add_product');
    Route::post('/add_product', [VendorProductController::class, 'store'])->name('vendor.store_product');
    Route::get('/products/{id}/edit', [VendorProductController::class, 'edit'])->name('vendor.edit_product');
    Route::put('/products/{id}', [VendorProductController::class, 'update'])->name('vendor.update_product');
    Route::delete('/products/{id}', [VendorProductController::class, 'destroy'])->name('vendor.destroy_product');
    Route::get('/products/{id}/detail', [VendorProductController::class, 'show'])->name('vendor.product_detail');
    Route::post('/vendor/products/upload', [VendorProductController::class, 'uploadBulk'])->name('vendor.upload_bulk_products');
    Route::post('/vendor/products/bulk-upload-images', [VendorProductController::class, 'uploadBulkWithImages'])->name('vendor.upload_bulk_with_images');

    // Vendor Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('vendor.orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('vendor.order_detail');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('vendor.order_update_status');
    Route::post('/bids/{id}/status', [OrderController::class, 'updateBidStatus'])->name('vendor.bid_update_status');

    // Profile Routes
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('components.profile');
    Route::get('/dashboard/profilevendor', [ProfileVendorController::class, 'edit'])->name('components.profilevendor');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/store/{store}', [StoreController::class, 'show'])->name('store.show');
});