<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\DashboardController;

Route::prefix('app')->group(function() {
    Route::get('/login/discord', [AuthController::class, 'login']);
    Route::get('/login', [AuthController::class, 'redirect']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth']);

    Route::prefix('requests')->group(function() {
        Route::get('/fetch', [RequestController::class, 'fetch']);
        Route::post('/create', [RequestController::class, 'create']);
        
        Route::get('/list', [RequestController::class, 'list'])->middleware(['auth']);
        Route::post('/delete', [RequestController::class, 'delete'])->middleware(['auth']);
        Route::post('/replay', [RequestController::class, 'replay'])->middleware(['auth']);
    });
});

Route::post('/app/publickey', [AppController::class, 'verifyPublicKey']);
Route::get('/{any}', [DashboardController::class, 'index'])->where('any', '.*');
