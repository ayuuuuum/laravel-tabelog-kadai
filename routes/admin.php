<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\ShopController;

//管理者しかアクセスできないように設定
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/categories/{id}/edit', [ImageController::class, 'edit'])->name('admin.categories.edit');
    Route::post('/categories/{id}/update', [ImageController::class, 'update'])->name('admin.categories.update');
    Route::get('/shops/{id}/edit', [ImageController::class, 'edit'])->name('admin.shops.edit');
    Route::post('/shops/{id}/update', [ImageController::class, 'update'])->name('admin.shops.update');
    Route::post('/shops/import', [ShopController::class, 'importCsv'])->name('shops.importCsv');
});