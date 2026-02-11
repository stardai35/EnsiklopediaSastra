<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CategoryController;

// Redirect old /login to /admin/login for backward compatibility
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Admin Routes (with auth middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [ContentController::class, 'dashboard'])->name('dashboard');
        Route::resource('contents', ContentController::class);
        Route::post('contents/{content}/media', [ContentController::class, 'storeMedia'])->name('contents.media.store');
        Route::put('contents/{content}/media/{media}', [ContentController::class, 'updateMedia'])->name('contents.media.update');
        Route::delete('contents/{content}/media/{media}', [ContentController::class, 'deleteMedia'])->name('contents.media.delete');
        Route::post('contents/{content}/media-upload', [ContentController::class, 'uploadMedia'])->name('contents.media.upload');
        Route::resource('categories', CategoryController::class);
    });
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/daftar-isi', [HomeController::class, 'daftarIsi'])->name('daftar-isi');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/penyusun', [HomeController::class, 'contributors'])->name('contributors');
Route::get('/kategori/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('/{slug}', [HomeController::class, 'detail'])->name('detail');
