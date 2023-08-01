<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'getTransactions']);
        Route::post('/', [TransactionController::class, 'addTransaction']);
        Route::post('/delete', [TransactionController::class, 'deleteTransaction']);
    });
});
