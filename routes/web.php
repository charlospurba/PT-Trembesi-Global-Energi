<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});
Route::get('/signin', function () {
    return view('auth.login');
});
Route::get('/signup', function () {
    return view('auth.register');
})->name('auth.register');

Route::get('/dashboard/profile', function () {
    return view('components.profile');
})->name('components.profile');

Route::get('/signup/form', function () {
    return view('auth.register_form');
})->name('auth.register_form');

Route::get('/material', function () {
    return view('procurement.material');
})->name('procurement.material');

Route::get('/equipment', function () {
    return view('procurement.equipment');
});

Route::get('/electrical', function () {
    return view('procurement.electrical');
});
Route::get('/consumables', function () {
    return view('procurement.consumables');
});
Route::get('/personal', function () {
    return view('procurement.personal');
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

Route::get('/detail', function () {
    return view('procurement.detail');
});