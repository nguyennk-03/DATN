<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/products', [AdminController::class, 'products'])->name('products');
Route::post('/admin/productadd', [AdminController::class, 'productadd'])->name('productadd');
Route::get('/admin/productdelete/{id}', [AdminController::class, 'productdelete'])->name('productdelete');
Route::get('/admin/productedit/{id}', [AdminController::class, 'productedit'])->name('productedit');
Route::put('/admin/productupdate/{id}', [AdminController::class, 'productupdate'])->name('productupdate');

Route::get('/admin/categories', [AdminController::class, 'categories'])->name('categories');
Route::post('/admin/categoryadd', [AdminController::class, 'categoryadd'])->name('categoryadd');
Route::get('/admin/categorydelete/{id}', [AdminController::class, 'categorydelete'])->name('categorydelete');
Route::get('/admin/categoryedit/{id}', [AdminController::class, 'categoryedit'])->name('categoryedit');
Route::put('/admin/categoryupdate/{id}', [AdminController::class, 'categoryupdate'])->name('categoryupdate');

Route::get('/admin/brands', [AdminController::class, 'brands'])->name('brands');
Route::post('/admin/brandadd', [AdminController::class, 'brandadd'])->name('brandadd');
Route::get('/admin/branddelete/{id}', [AdminController::class, 'branddelete'])->name('branddelete');
Route::get('/admin/brandedit/{id}', [AdminController::class, 'brandedit'])->name('brandedit');
Route::put('/admin/brandupdate/{id}', [AdminController::class, 'brandupdate'])->name('brandupdate');

Route::get('/admin/users', [AdminController::class, 'users'])->name('users');
Route::get('/admin/useradd', [AdminController::class, 'useradd'])->name('useradd');
Route::get('/admin/userdelete/{id}', [AdminController::class, 'userdelete'])->name('userdelete');
Route::get('/admin/useredit/{id}', [AdminController::class, 'useredit'])->name('useredit');
Route::put('/admin/userupdate/{id}', [AdminController::class, 'userupdate'])->name('userupdate');

