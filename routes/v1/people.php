<?php

declare(strict_types=1);

use App\Http\Controllers\V1\People\DeletePersonController;
use App\Http\Controllers\V1\People\IndexPeopleController;
use App\Http\Controllers\V1\People\ShowPersonController;
use App\Http\Controllers\V1\People\StorePersonController;
use App\Http\Controllers\V1\People\UpdatePersonController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/people')->group(function () {
    Route::get('/', IndexPeopleController::class);
    Route::get('/{personId}', ShowPersonController::class);
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::post('/', StorePersonController::class);
        Route::match(['put', 'patch'], '/{person}', UpdatePersonController::class);
        Route::delete('/{person}', DeletePersonController::class);
    });
});
