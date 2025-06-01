<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::resource('users', UserController::class)->only('index', 'store', 'edit', 'update', 'destroy');
        Route::resource('transactions', TransactionController::class)->only('index', 'store', 'edit', 'update', 'destroy');
    }
);
