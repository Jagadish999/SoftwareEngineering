<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserNavigationController;
use App\Http\Controllers\AddProduct;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerNavigationController;
use App\Http\Controllers\CustomerBidRecorder;
use App\Http\Controllers\ProductUpdater;
use App\Http\Controllers\SearchController;

Route::get('/dashboard', [UserNavigationController::class, 'dashboardView'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware(['auth', 'verified']);


Route::get('/addcategory', [UserNavigationController::class, 'addCategoryView'])->middleware(['auth', 'verified'])->name('addcategory');

Route::get('/addProduct', [UserNavigationController::class, 'addProductView'])->middleware(['auth', 'verified'])->name('addproductView');

Route::post('/create-category', [CategoryController::class, 'store'])->middleware(['auth', 'verified'])->name('create-category');

Route::get('/addProduct/{productCategory}', [AddProduct::class, 'newProductDetails'])->middleware(['auth', 'verified'])->name('addproductForm');

Route::post('/submit-product', [AddProduct::class, 'submitProduct'])->middleware(['auth', 'verified'])->name('submitProduct');

Route::get('/productView', [UserNavigationController::class, 'allProductView'])->middleware(['auth', 'verified']);

Route::get('/customerBuyProduct', [CustomerNavigationController::class, 'buyProductList'])->middleware(['auth', 'verified'])->name('customerBuyProduct');

Route::post('/insertCustomerBid', [CustomerBidRecorder::class, 'insertCustomerBids'])->middleware(['auth', 'verified']);

Route::get('/pendingProduct', [CustomerNavigationController::class, 'pendingProduct'])->middleware(['auth', 'verified']);


Route::get('/approvedProduct', [CustomerNavigationController::class, 'approvedProduct'])->middleware(['auth', 'verified']);

Route::post('/updateProductStatus', [ProductUpdater::class, 'updateProductStatus'])->middleware(['auth', 'verified']);

Route::get('/adminApprovesProduct', [UserNavigationController::class, 'approveViewAdmin'])->middleware(['auth', 'verified']);

Route::post('/updateBiddingStatus', [CustomerBidRecorder::class, 'updateStatusByAdminAction'])->middleware(['auth', 'verified']);

Route::post('/deleteCategory', [CategoryController::class, 'deleteSpecificCategory'])->middleware(['auth', 'verified']);

Route::post('/deleteProduct', [CategoryController::class, 'deleteSpecificProduct'])->middleware(['auth', 'verified']);

Route::post('/deleteBid', [CategoryController::class, 'deleteSpecificBid'])->middleware(['auth', 'verified']);



Route::get('/search/results', [SearchController::class, 'index'])->name('search.results');






Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
