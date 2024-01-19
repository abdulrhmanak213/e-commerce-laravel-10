<?php

use App\Http\Controllers\Admin\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\City\CityController;
use App\Http\Controllers\Admin\Color\ColorController;
use App\Http\Controllers\Admin\Contact\ContactController;
use App\Http\Controllers\Admin\Country\CountryController;
use App\Http\Controllers\Admin\Currency\CurrencyController;
use App\Http\Controllers\Admin\HeroImage\HeroImageController;
use App\Http\Controllers\Admin\Order\InvoiceController;
use App\Http\Controllers\Admin\Order\OrderController;
use App\Http\Controllers\Admin\Policy\PolicyController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\ReviewRate\ReviewRateController;
use App\Http\Controllers\Admin\Sale\SaleController;
use App\Http\Controllers\Admin\Term\TermController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\User\Auth\ResetPasswordController;


Route::post('login', [LoginController::class, 'login']);
Route::post('resetPassword', [ResetPasswordController::class, 'resetPassword']);
Route::post('checkCode', [ResetPasswordController::class, 'checkCode']);
Route::post('editPassword', [ResetPasswordController::class, 'editPassword']);

Route::middleware(['auth:user', 'role:admin,user'])->group(function () {
    Route::get('logout', [LogoutController::class, 'logout']);
    Route::apiResource('/admins', AdminController::class);
    Route::get('/admins/restore/{id}', [AdminController::class, 'restore']);

    Route::get('profile', [ProfileController::class, 'show']);
    Route::post('profile/change-password', [ProfileController::class, 'changePassword']);

    Route::apiResource('/country', CountryController::class);
    Route::apiResource('/city', CityController::class);

    Route::apiResource('product', ProductController::class);
    Route::get('product/restore/{id}', [ProductController::class, 'restore']);
    Route::get('product/sale-toggle/{id}', [ProductController::class, 'onSaleToggle']);


    Route::apiResource('/category', CategoryController::class);
    Route::get('/category/restore/{id}', [CategoryController::class, 'restore']);

    Route::apiResource('/color', ColorController::class);
    Route::get('/color/restore/{id}', [ColorController::class, 'restore']);

    Route::apiResource('/user', UserController::class);
    Route::get('/user/restore/{id}', [UserController::class, 'restore']);
    Route::get('/user/block-toggle/{id}', [UserController::class, 'blockToggle']);

    Route::prefix('/order')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/{id}', [OrderController::class, 'show']);
        Route::post('/changeOrderStatus/{id}', [OrderController::class, 'changeOrderStatus']);
    });

    Route::prefix('/invoice')->group(function () {
        Route::get('/', [InvoiceController::class, 'index']);
        Route::get('/{id}', [InvoiceController::class, 'show']);
    });

    Route::prefix('reviewRate')->group(function () {
        Route::get('/', [ReviewRateController::class, 'index']);
        Route::get('/{id}', [ReviewRateController::class, 'show']);
        Route::get('/showToggle/{id}', [ReviewRateController::class, 'showToggle']);
    });
    Route::prefix('sale')->group(function () {
        Route::get('/', [SaleController::class, 'show']);
        Route::post('/', [SaleController::class, 'store']);
    });
    Route::prefix('hero-image')->group(function () {
        Route::get('/', [HeroImageController::class, 'show']);
        Route::post('/', [HeroImageController::class, 'store']);
    });
    Route::get('policy', [PolicyController::class, 'show']);
    Route::get('term', [TermController::class, 'show']);
    Route::post('policy', [PolicyController::class, 'store']);
    Route::post('term', [TermController::class, 'store']);

    Route::get('/currency', [CurrencyController::class, 'show']);
    Route::put('/currency', [CurrencyController::class, 'update']);
    Route::prefix('contact')->group(function () {
        Route::get('/', [ContactController::class, 'index']);
        Route::get('/{id}', [ContactController::class, 'show']);
        Route::post('/', [ContactController::class, 'store']);
    });
});
