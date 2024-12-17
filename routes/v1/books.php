<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Books\DeleteBookController;
use App\Http\Controllers\V1\Books\IndexBookController;
use App\Http\Controllers\V1\Books\ShowBookController;
use App\Http\Controllers\V1\Books\StoreBookController;
use App\Http\Controllers\V1\Books\UpdateBookController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/books')->group(function () {
    Route::get('/', IndexBookController::class);
    Route::get('/{bookId}', ShowBookController::class);
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::post('/', StoreBookController::class);
        Route::match(['put', 'patch'], '/{book}', UpdateBookController::class);
        Route::delete('/{book}', DeleteBookController::class);
    });
});
