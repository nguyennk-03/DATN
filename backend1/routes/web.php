<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/products', [AdminController::class, 'products'])->name('products');
