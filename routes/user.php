<?php

use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Auth\ResetPasswordController;
use App\Http\Controllers\User\Cart\CartController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\Contact\ContactController;
use App\Http\Controllers\User\CountryController;
use App\Http\Controllers\User\HeroImageController;
use App\Http\Controllers\User\Order\OrderController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->middleware('role:user,user');

Route::post('resetPassword', [ResetPasswordController::class, 'resetPassword']);
Route::post('checkCode', [ResetPasswordController::class, 'checkCode']);
Route::post('editPassword', [ResetPasswordController::class, 'editPassword']);


Route::get('country', [CountryController::class, 'getCountry']);
Route::get('cities', [CountryController::class, 'getCity']);


/////// home page
Route::get('get-category', [CategoryController::class, 'index']); // category home page
Route::get('all-category', [CategoryController::class, 'allCategory']); // selected
Route::get('all-color', [ProductController::class, 'allColor']);

Route::get('get-product', [ProductController::class, 'getAll']);
Route::get('product/{product}', [ProductController::class, 'show']);
Route::get('product/similar/{id}', [ProductController::class, 'getSimilar']);

Route::get('heroImage', [HeroImageController::class, 'show']);


///// cart
Route::get('/cart', [CartController::class, 'show']);
Route::get('/cart/addProduct/{product}', [CartController::class, 'addProduct']);
Route::get('/cart/increaseProduct/{product}', [CartController::class, 'increaseProduct']);
Route::get('/cart/decreaseProduct/{product}', [CartController::class, 'decreaseProduct']);
Route::delete('/cart/removeProduct/{product}', [CartController::class, 'removeProduct']);

Route::middleware(['auth:user', 'role:user,user'])->group(function () {
    Route::get('get-order', [OrderController::class, 'index']);
    Route::get('order/{order}', [OrderController::class, 'show']);
    Route::get('get-order/{order}', [OrderController::class, 'getOrder']);
    Route::post('review/{order}', [ReviewController::class, 'review']);
});

/////// order route
Route::post('order/checkout', [CartController::class, 'checkOut']);
Route::get('get-order', [OrderController::class, 'index'])->middleware('role:user,user');
Route::get('order/{order}', [OrderController::class, 'show']);
Route::get('get-order/{order}', [OrderController::class, 'getOrder']);


////// review route
Route::post('review/{order}', [ReviewController::class, 'review']);
Route::get('reviews', [ReviewController::class, 'index']);
Route::get('contact', [ContactController::class, 'show']);


// home page
Route::post('subscribe', [SubscriberController::class, 'store']);
Route::post('contact-us', [SubscriberController::class, 'contactUs']);

Route::get('/test', function () {
    dd(\Illuminate\Support\Facades\Config::get('app.location'));
});
