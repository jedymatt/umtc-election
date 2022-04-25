<?php

use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ElectionVoteController;
use App\Http\Controllers\ElectionWinnerController;
use App\Http\Controllers\UserProfileController;

Route::middleware('auth')->group(function () {
    Route::resource('/elections', ElectionController::class)
        ->only(['index', 'show']);

    Route::resource('/elections.vote', ElectionController::class)
        ->only(['create', 'store']);

    Route::get('/user/profile', [UserProfileController::class, 'show'])
        ->name('user-profile');

    Route::put('/user/profile', [UserProfileController::class, 'update']);

    Route::get('/elections/{election}/winners', [ElectionWinnerController::class, 'show'])
        ->name('elections.winners');
});
