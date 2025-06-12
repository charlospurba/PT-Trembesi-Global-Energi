<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProcurementHomeController;

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

// ✅ Setelah login, redirect berdasarkan role ke halaman dashboard masing-masing
Route::middleware('auth')->group(function () {
    Route::view('/dashboard/superadmin', 'dashboard.superadmin')->name('dashboard.superadmin');
    Route::view('/dashboard/procurement', 'dashboard.procurement')->name('dashboard.procurement');
    Route::view('/dashboard/vendor', 'dashboard.vendor')->name('dashboard.vendor');
    Route::view('/dashboard/productmanager', 'dashboard.productmanager')->name('dashboard.productmanager');
});

// 👷 Khusus route Procurement yang hanya bisa diakses setelah login & cek middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/procurement', [ProcurementHomeController::class, 'index'])->name('procurement.dashboardproc');

    // Procurement views
    Route::view('/material', 'procurement.material')->name('procurement.material');
    Route::view('/equipment', 'procurement.equipment')->name('procurement.equipment');
    Route::view('/electrical', 'procurement.electrical')->name('procurement.electrical');
    Route::view('/consumables', 'procurement.consumables')->name('procurement.consumables');
    Route::view('/personal', 'procurement.personal')->name('procurement.personal');
    Route::view('/cart', 'procurement.cart')->name('procurement.cart');
    Route::view('/detail', 'procurement.detail')->name('procurement.detail');
});


Route::get('/cart', function () {
    // Mengambil data cart dari session, jika tidak ada maka cartItems akan kosong
    $cartItems = session()->get('cart', []);

    // Menghitung total harga cart jika diperlukan
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    // Mengirimkan data cartItems dan totalPrice ke view
    return view('procurement.cart', compact('cartItems', 'totalPrice'));
});

Route::get('/dashboard/profile', function () {
    return view('components.profile');
})->name('components.profile');