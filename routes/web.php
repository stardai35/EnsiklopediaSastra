<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnsisaController;

Route::get('/', [EnsisaController::class, 'home']);
Route::get('/kategori/{slug}', [EnsisaController::class, 'category']);
Route::get('/konten/{slug}', [EnsisaController::class, 'content']);
use App\Http\Controllers\EncyclopediaController;

Route::get('/', [EncyclopediaController::class, 'index'])->name('home');
Route::get('/wiki/{slug}', [EncyclopediaController::class, 'show'])->name('wiki.show');