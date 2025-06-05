<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('auth.register');

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