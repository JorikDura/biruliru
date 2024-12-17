<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Auth\Images\DeleteUserImageController;
use App\Http\Controllers\V1\Auth\Images\StoreUserImageController;
use App\Http\Controllers\V1\Auth\LoginController;
use App\Http\Controllers\V1\Auth\LogoutController;
use App\Http\Controllers\V1\Auth\RegisterController;
use App\Http\Controllers\V1\Auth\ResendCodeVerificationController;
use App\Http\Controllers\V1\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('email/verification')->group(function () {
            Route::post('/verify', VerifyEmailController::class);
            Route::post('/resend', ResendCodeVerificationController::class);
        });
        Route::group(['prefix' => 'images', 'middleware' => ['verified']], function () {
            Route::post('/', StoreUserImageController::class);
            Route::delete('/', DeleteUserImageController::class);
        });
    });
});
