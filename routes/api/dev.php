<?php

use App\Http\Controllers\DevController;

if (app()->environment(['local', 'staging', 'testing'])) {
    Route::prefix('dev')->group(function () {
        Route::get('jwt-token/{user_id}', [DevController::class, 'jwtToken'])->name('dev.jwt-token');
    });
}
