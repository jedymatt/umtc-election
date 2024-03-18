<?php

use App\Http\Controllers\Student\ElectionController;
use App\Http\Controllers\Student\ElectionResultController;
use App\Http\Controllers\Student\ElectionVoteController;
use App\Http\Controllers\Student\UserProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('elections.index'))
        ->name('dashboard');

    Route::resource('/elections', ElectionController::class)
        ->only(['index', 'show']);

    Route::get('/elections/{election}/vote', [ElectionVoteController::class, 'create'])
        ->name('elections.vote');

    Route::post('/elections/{election}/vote', [ElectionVoteController::class, 'store']);

    Route::get('/user/profile', [UserProfileController::class, 'show'])
        ->name('user-profile');

    Route::get('/elections/{election}/result', [ElectionResultController::class, 'show'])
        ->name('elections.result');
});
