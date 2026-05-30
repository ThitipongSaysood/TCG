<?php

use App\Auth\AuthController;
use App\Pages\PageController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/',                          [PageController::class, 'home'])->name('home');
Route::get('/products',                  [PageController::class, 'products'])->name('products.index');
Route::get('/products/{id}',             [PageController::class, 'productShow'])->name('products.show');
Route::get('/auctions',                  [PageController::class, 'auctions'])->name('auctions.index');
Route::get('/auctions/{id}',             [PageController::class, 'auctionShow'])->name('auctions.show');
Route::get('/live',                      [PageController::class, 'live'])->name('live.index');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',                 [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',                [AuthController::class, 'login']);
    Route::get('/register',              [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',             [AuthController::class, 'register']);

    // Social OAuth — server-side redirect flow (session-based)
    Route::get('/login/{provider}/redirect', [AuthController::class, 'redirectToProvider'])
        ->whereIn('provider', ['line', 'google'])
        ->name('login.social.redirect');
    Route::get('/login/{provider}/callback', [AuthController::class, 'handleProviderCallback'])
        ->whereIn('provider', ['line', 'google'])
        ->name('login.social.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated user area
Route::middleware('auth')->group(function () {
    Route::get('/cart',                  [PageController::class, 'cart'])->name('cart.index');
    Route::get('/checkout',              [PageController::class, 'checkout'])->name('checkout.index');
    Route::get('/my-collection',         [PageController::class, 'collection'])->name('collection.index');
    Route::get('/my-orders',             [PageController::class, 'orders'])->name('orders.index');
    Route::get('/psa-submission',        [PageController::class, 'psa'])->name('psa.index');
    Route::get('/tracking/{id}',         [PageController::class, 'tracking'])->name('tracking.show');
    Route::get('/profile',               [PageController::class, 'profile'])->name('profile.show');
});
