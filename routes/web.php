<?php

use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ElectionResultController;
use App\Http\Controllers\ElectionVoteController;
use App\Http\Controllers\ElectionWinnerController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('/elections', ElectionController::class)
    ->only('index', 'show')
    ->middleware('auth');

Route::get('/elections/{election}/vote', [ElectionVoteController::class, 'create'])
    ->middleware('auth')
    ->name('elections.vote.create');

Route::post('/elections/{election}/vote', [ElectionVoteController::class, 'store'])
    ->middleware('auth')
    ->name('elections.vote.store');

Route::get('/elections/{election}/result', [ElectionResultController::class, 'show'])
    ->middleware('auth')
    ->name('elections.result');

Route::get('/user/profile', [UserProfileController::class, 'show'])
    ->middleware('auth')
    ->name('user-profile');

Route::put('/user/profile', [UserProfileController::class, 'update'])
    ->middleware('auth')
    ->name('user-profile');

Route::get('/elections/{election}/winners', [ElectionWinnerController::class, 'show'])
    ->middleware('auth')
    ->name('elections.winners');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
