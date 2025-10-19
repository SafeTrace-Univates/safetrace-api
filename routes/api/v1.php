<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\SystemController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login')->middleware('throttle:5,1');
        Route::post('register', [AuthController::class, 'register'])->name('auth.register')->middleware('throttle:5,1');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('user', [AuthController::class, 'user'])->name('auth.user');
            Route::post('set-role', [AuthController::class, 'setActiveRole'])->name('auth.set-active-role');
            Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('setting', [SettingController::class, 'config'])->name('setting.config');

        Route::apiResource('system', SystemController::class)
            ->only(['index', 'show', 'store', 'destroy'])
            ->names('system');

        Route::apiResource('user', UserController::class)
            ->only(['index', 'show']);

        Route::apiResource('contact', ContactController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('contact');

        Route::post('user/{user}/sync-role', [UserController::class, 'syncRoles'])->name('user.sync-roles');
    });
});
