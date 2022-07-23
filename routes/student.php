<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ElectionResultController;
use App\Http\Controllers\ElectionVoteController;
use App\Http\Controllers\UserProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])
        ->name('dashboard');

    Route::resource('/elections', ElectionController::class)
        ->only(['index', 'show']);

    Route::get('/elections/{election}/vote', [ElectionVoteController::class, 'create'])
        ->name('elections.vote');

    Route::post('/elections/{election}/vote', [ElectionVoteController::class, 'store']);

    Route::get('/user/profile', [UserProfileController::class, 'show'])
        ->name('user-profile');

    Route::put('/user/profile', [UserProfileController::class, 'update']);

    Route::get('/elections/{election}/result', [ElectionResultController::class, 'show'])
        ->name('elections.result');
});
