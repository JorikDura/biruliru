<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Users\IndexUserController;
use App\Http\Controllers\V1\Users\ShowUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/users')->group(function () {
    Route::get('/', IndexUserController::class);
    Route::get('/{user}', ShowUserController::class);
});
