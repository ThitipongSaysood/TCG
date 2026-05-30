<?php

use App\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — CARD ZONE
|--------------------------------------------------------------------------
| Auth (public): register, login, social redirect/callback
| Auth (protected): logout, me — require Sanctum Bearer token
*/

Route::prefix('auth')->group(function () {
    // Email / password
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);

    // Social OAuth — server-side redirect flow (LINE, Google)
    Route::get('/{provider}/redirect', [AuthController::class, 'redirectToProvider'])
        ->whereIn('provider', ['line', 'google']);
    Route::get('/{provider}/callback', [AuthController::class, 'handleProviderCallback'])
        ->whereIn('provider', ['line', 'google']);

    // Social OAuth — token-based flow (mobile/SPA passes access_token they got client-side)
    Route::post('/{provider}/token', [AuthController::class, 'loginWithProviderToken'])
        ->whereIn('provider', ['line', 'google']);

    // Authenticated
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me',      [AuthController::class, 'me']);
    });
});
