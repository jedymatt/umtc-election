<?php

use App\Http\Controllers\ElectionWinnerController;

Route::get('/elections/{election}/winners', [ElectionWinnerController::class, 'show'])
    ->middleware('auth')
    ->name('elections.winners');
