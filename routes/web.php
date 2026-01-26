<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CategoryController;

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes (with auth middleware)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [ContentController::class, 'dashboard'])->name('dashboard');
    Route::resource('contents', ContentController::class);
    Route::resource('categories', CategoryController::class);
    Route::delete('/images/{image}', [ContentController::class, 'deleteImage'])->name('images.delete');
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/daftar-isi', [HomeController::class, 'daftarIsi'])->name('daftar-isi');
Route::get('/kategori/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('/{slug}', [HomeController::class, 'detail'])->name('detail');
