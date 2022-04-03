<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\CdsgElectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DsgElectionController;
use App\Http\Controllers\Admin\ElectionController;
use App\Http\Controllers\Admin\ElectionResultController;
use App\Http\Controllers\Admin\EventCdsgElectionController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventDsgElectionController;
use App\Http\Controllers\Admin\ExportElectionResultController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('auth:admin');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('auth:admin')
        ->name('dashboard');

    // Route::get('/register', [RegisteredUserController::class, 'create'])
    //     ->middleware('guest:admin')
    //     ->name('register');

    // Route::post('/register', [RegisteredUserController::class, 'store'])
    //     ->middleware('guest:admin');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest:admin')
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest:admin');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware('guest:admin')
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest:admin')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest:admin')
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest:admin')
        ->name('password.update');

    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->middleware('auth:admin')
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth:admin', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:admin', 'throttle:6,1'])
        ->name('verification.send');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->middleware('auth:admin')
        ->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware('auth:admin');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:admin')
        ->name('logout');

    Route::resource('/admins', AdminController::class)
        ->only(['index', 'show', 'create', 'store'])
        ->middleware('auth:admin');

    Route::resource('/elections', ElectionController::class)
        ->except('create')
        ->middleware('auth:admin');

    Route::get('/elections/{election}/result', [ElectionResultController::class, 'show'])
        ->middleware('auth:admin')
        ->name('elections.result.show');

    Route::get('/elections/{election}/result/export-excel', [ExportElectionResultController::class, 'store'])
        ->middleware('auth:admin')
        ->name('elections.result.export-excel');


    Route::get('/events/{event}/dsg-elections/create', [EventDsgElectionController::class, 'create'])
        ->middleware('auth:admin')
        ->name('events.dsg-election.create');

    Route::post('/events/{event}/dsg-elections/create', [EventDsgElectionController::class, 'store'])
        ->middleware('auth:admin')
        ->name('events.dsg-election.store');

    Route::get('/events/{event}/cdsg-elections/create', [EventCdsgElectionController::class, 'create'])
        ->middleware('auth:admin')
        ->name('events.cdsg-election.create');

    Route::post('/events/{event}/cdsg-elections/create', [EventCdsgElectionController::class, 'store'])
        ->middleware('auth:admin')
        ->name('events.cdsg-election.store');

    Route::resource('/events', EventController::class)
        ->middleware('auth:admin')
        ->only(['index', 'show', 'create', 'store']);

});
