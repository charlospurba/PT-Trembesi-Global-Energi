<?php

use App\Http\Middleware\CheckUserStatus;
use App\Http\Controllers\VendorHomeController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSAController;
use App\Http\Controllers\ProfilePMController;
use App\Http\Controllers\ProfileVendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\VendorApprovalController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\PMRequestController;
use Illuminate\Support\Facades\Route;

// 🏠 Default Routes
Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard.home');

// 📄 Authentication Views
Route::view('/signin', 'auth.login')->name('signin');
Route::view('/signup', 'auth.register')->name('auth.register');
Route::view('/signup/form', 'auth.register_form')->name('auth.register_form');
Route::get('/registration-status', function () {
    return view('vendor.status');
})->middleware('auth')->name('vendor.registration_status');

// 🔐 Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Split view for registration details
Route::get('/register-detail', function () {
    return view('auth.register_form_detail');
})->name('register.step2');

// Combined registration form submission
Route::post('/register-detail', [RegisterController::class, 'register'])->name('auth.register_detail_submit');

// ✅ Authenticated Routes
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    // Superadmin & Product Manager Routes
    // Superadmin Dashboard
    Route::get('/dashboard/superadmin', [UserManagementController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/dashboard/superadmin/request', [VendorApprovalController::class, 'index'])->name('superadmin.request');
    Route::view('/dashboard/superadmin/add_users', 'superadmin.add_users')->name('superadmin.add_users');

    // Superadmin User Management
    Route::get('/superadmin/users/add', [UserManagementController::class, 'create'])->name('superadmin.users.create');
    Route::post('/superadmin/users/store', [UserManagementController::class, 'store'])->name('superadmin.users.store');
    Route::get('/superadmin/users/edit/{id}', [UserManagementController::class, 'edit'])->name('superadmin.edit');
    Route::post('/superadmin/users/update/{id}', [UserManagementController::class, 'update'])->name('superadmin.users.update');
    Route::delete('/superadmin/users/{id}', [UserManagementController::class, 'destroy'])->name('superadmin.users.destroy');

    // Superadmin Vendor Approval
    Route::prefix('superadmin')->group(function () {
        Route::get('/vendor-requests', [VendorApprovalController::class, 'index'])->name('superadmin.vendor.requests');
        Route::get('/vendor-requests/{id}', [VendorApprovalController::class, 'show'])->name('superadmin.vendor.detail');
        Route::post('/vendor-requests/{id}/accept', [VendorApprovalController::class, 'accept'])->name('superadmin.vendor.accept');
        Route::post('/vendor-requests/{id}/reject', [VendorApprovalController::class, 'reject'])->name('superadmin.vendor.reject');
    });

    // Project Manager Routes
    Route::view('/dashboard/projectmanager', 'projectmanager.dashboardpm')->name('dashboard.projectmanager');
    Route::get('/projectmanager/addrequest', [PMRequestController::class, 'showAll'])->name('projectmanager.addrequest');
    Route::view('/projectmanager/formadd', 'projectmanager.formadd')->name('projectmanager.formadd');

    Route::get('/projectmanager/purchase-requests', [PurchaseRequestController::class, 'index'])->name('projectmanager.purchase_requests');
    Route::get('/projectmanager/purchase-requests/{id}', [PurchaseRequestController::class, 'showDetail'])->name('projectmanager.purchase_requests.detail');
    Route::post('/projectmanager/purchase-requests/{id}/approve', [PurchaseRequestController::class, 'approve'])->name('projectmanager.purchase.approve');
    Route::post('/projectmanager/purchase-requests/{id}/reject', [PurchaseRequestController::class, 'reject'])->name('projectmanager.purchase.reject');

    Route::resource('pm-requests', PMRequestController::class);

    // Procurement Routes
    Route::get('/dashboard/procurement', [ProductController::class, 'dashboard'])->name('procurement.dashboardproc');
    Route::get('/material', [ProductController::class, 'materialProducts'])->name('procurement.material');
    Route::get('/equipment', [ProductController::class, 'equipmentProducts'])->name('procurement.equipment');
    Route::get('/consumables', [ProductController::class, 'consumablesProducts'])->name('procurement.consumables');
    Route::get('/electrical', [ProductController::class, 'electricalProducts'])->name('procurement.electrical');
    Route::get('/personal', [ProductController::class, 'personalProducts'])->name('procurement.personal');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
    Route::get('/search', [ProductController::class, 'search'])->name('search.products');

    // Searching
    Route::get('/material/search', [ProductController::class, 'searchMaterial'])->name('search.material');
    Route::get('/equipment/search', [ProductController::class, 'searchEquipment'])->name('search.equipment');
    Route::get('/electrical/search', [ProductController::class, 'searchElectrical'])->name('search.electrical');
    Route::get('/consumables/search', [ProductController::class, 'searchConsumables'])->name('search.consumables');
    Route::get('/personal/search', [ProductController::class, 'searchPersonal'])->name('search.personal');

    // Notes Routes
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
    Route::post('/cart/request-purchase', [CartController::class, 'requestPurchase'])->name('cart.request-purchase');
    Route::post('/pmrequest/import', [PMRequestController::class, 'import'])->name('pmrequest.import');
    Route::get('/pmrequest/template', [PMRequestController::class, 'downloadTemplate'])->name('pmrequest.downloadTemplate');

    // Checkout Routes
    Route::match(['get', 'post'], '/procurement/checkout', [CheckoutController::class, 'checkout'])->name('procurement.checkout');
    Route::post('/procurement/checkout/submit', [CheckoutController::class, 'submitCheckout'])->name('procurement.checkout.submit');
    Route::post('/checkout/e-billing', [CheckoutController::class, 'generateEBilling'])->name('checkout.e-billing');
    Route::get('/e-billing/view/{notificationId}', [CheckoutController::class, 'viewEBilling'])->name('ebilling.view');

    // Order History Route
    Route::get('/procurement/order-history', [OrderController::class, 'orderHistory'])->name('procurement.order_history');
    Route::post('/orders/{orderId}/rate', [OrderController::class, 'submitRating'])->name('orders.rate');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read_all');

    // Vendor Routes
    Route::get('/dashboard/vendor', [VendorHomeController::class, 'index'])->name('vendor.dashboardvendor');
    Route::get('/vendor/sales-data', [VendorHomeController::class, 'getSalesData'])->name('vendor.sales-data');
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
    Route::get('/dashboard/profilepm', [ProfilePMController::class, 'edit'])->name('components.profilepm');
    Route::get('/dashboard/profilesa', [ProfileSAController::class, 'edit'])->name('components.profilesa');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Store Routes
    Route::get('/store/{store}', [StoreController::class, 'show'])->name('store.show');
    Route::get('/store/{store}/reviews', [StoreController::class, 'getStoreReviews'])->name('store.reviews');
});