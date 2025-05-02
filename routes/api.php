<?php

use App\Http\Controllers\Api\CredentialController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\PersonUserController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckToken;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(CheckToken::class)->post('/auth/logout', [AuthController::class, 'logout']);


Route::prefix('admin')->middleware(CheckToken::class)->group(function () {
    Route::prefix('credential')->group(function () {
        Route::get('/', [CredentialController::class, 'index']);
        Route::post('/', [CredentialController::class, 'store']);
        Route::get('/{id}', [CredentialController::class, 'show']);
        Route::put('/{id}', [CredentialController::class, 'update']);
        Route::delete('/{id}', [CredentialController::class, 'destroy']);
    });

    Route::prefix('person')->group(function () {
        Route::get('/', [PersonController::class, 'index']);
        Route::post('/', [PersonController::class, 'store']);
        Route::get('/{id}', [PersonController::class, 'show']);
        Route::put('/{id}', [PersonController::class, 'update']);
        Route::delete('/{id}', [PersonController::class, 'destroy']);
    });

    Route::prefix('person-user')->group(function () {
        Route::get('/', [PersonUserController::class, 'index']);
        Route::post('/', [PersonUserController::class, 'store']);
        Route::get('/{id}', [PersonUserController::class, 'show']);
        Route::put('/{id}', [PersonUserController::class, 'update']);
        Route::delete('/{id}', [PersonUserController::class, 'destroy']);
    });

    Route::prefix('token')->group(function () {
        Route::get('/', [TokenController::class, 'index']);
        Route::post('/', [TokenController::class, 'store']);
        Route::get('/{id}', [TokenController::class, 'show']);
        Route::put('/{id}', [TokenController::class, 'update']);
        Route::delete('/{id}', [TokenController::class, 'destroy']);
    });
});
