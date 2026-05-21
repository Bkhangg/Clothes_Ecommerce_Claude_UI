<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::delete('categories/bulk-delete', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
    Route::resource('categories', CategoryController::class);

    Route::delete('products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';
