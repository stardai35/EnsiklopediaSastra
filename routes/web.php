<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Content;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/kategori/{slug}', function ($slug) {
    $category = Category::where('slug', $slug)->firstOrFail();
    return view('pages.category', compact('category'));
})->name('category.show');

Route::get('/wiki/{slug}', function ($slug) {
    $content = Content::where('slug', $slug)->firstOrFail();
    return view('pages.detail', ['article' => $content]);
})->name('wiki.show');