<?php

use App\Http\Controllers\CashTransactionController;
use App\Http\Controllers\IdentitySettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('transactions')->group(function () {
    Route::post('/cash-in', [CashTransactionController::class, 'cashIn']);
    Route::post('/cash-out', [CashTransactionController::class, 'cashOut']);
    Route::post('/transfer', [CashTransactionController::class, 'transfer']);
    Route::get('/{journal}', [CashTransactionController::class, 'show']);
    Route::patch('/{journal}/status', [CashTransactionController::class, 'updateStatus']);
});

Route::post('/branches/{branch}/identity', [IdentitySettingsController::class, 'update']);
