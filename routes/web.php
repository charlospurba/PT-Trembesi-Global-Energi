<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('auth.register');
