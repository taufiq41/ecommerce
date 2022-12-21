<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\user\ProductDetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionAdminController;


//Route::get('/product/{productId}', [ProductDetailController::class, 'index'])->name('product.detail')->middleware('roleUserOrGuest');
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => ['roleAdmin']], function(){
        Route::prefix('admin')->group(function () {
            Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');

            Route::get('product/datatable', [ProductController::class, 'datatable'])->name('admin.product.datatable');
            Route::get('product/export', [ProductController::class, 'export'])->name('admin.product.export');
            Route::resource('product', ProductController::class, ['as' => 'admin']);

            Route::get('transaction/export', [TransactionAdminController::class, 'export'])->name('admin.transaction.export');
            Route::resource('transaction', TransactionAdminController::class, ['as' => 'admin']);
        });
    });

    Route::group(['middleware' => ['roleUser']], function(){
        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::get('/product/{productId}', [ProductDetailController::class, 'index'])->name('product.detail');

        Route::post('cart/add', [CartController::class, 'add'])->name('user.cart.add');
        Route::resource('cart', CartController::class, ['as' => 'user']);
        Route::resource('transaction', TransactionController::class, ['as' => 'user']);
    });
});
