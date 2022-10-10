<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Models\Election;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])
        ->middleware('auth:admin');

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
        ->middleware('auth:admin')
        ->name('dashboard');

    // Route::get('/register', [RegisteredUserController::class, 'create'])
    //     ->middleware('guest:admin', 'guest')
    //     ->name('register');

    // Route::post('/register', [RegisteredUserController::class, 'store'])
    //     ->middleware('guest:admin', 'guest');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest:admin', 'guest')
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest:admin', 'guest');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware('guest:admin', 'guest')
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest:admin', 'guest')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest:admin', 'guest')
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest:admin', 'guest')
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

    // Routes for authenticated admin
    Route::middleware('auth:admin')->group(function () {
        Route::resource('/admin-management', Admin\AdminController::class)
            ->only(['index', 'create', 'store']);

        Route::resource('/elections', Admin\ElectionController::class)
            ->only(['index', 'show', 'create']);

        Route::get('/events/{event}/dsg-elections/create', [Admin\EventDsgElectionController::class, 'create'])
            ->middleware(\App\Http\Middleware\EnsureCanCreateElection::class)
            ->name('events.dsg-elections.create');

        Route::post('/events/{event}/dsg-elections', [Admin\EventDsgElectionController::class, 'store'])
            ->name('events.dsg-elections.store');

        Route::get('/events/{event}/cdsg-elections/create', [Admin\EventCdsgElectionController::class, 'create'])
            ->middleware(\App\Http\Middleware\EnsureCanCreateElection::class)
            ->name('events.cdsg-elections.create');

        Route::post('/events/{event}/cdsg-elections', [Admin\EventCdsgElectionController::class, 'store'])
            ->name('events.cdsg-elections.store');

        Route::resource('/events', Admin\EventController::class)
            ->only(['index', 'show', 'create', 'store']);

        Route::get('/monitor-election/{election}', [Admin\MonitorElectionController::class, 'show'])
            ->name('monitor-election');

        Route::get('/elections/{election}/winners/export-excel', [Admin\ElectionWinnerExportExcelController::class, 'store'])
            ->name('elections.winners.export-excel');

        Route::post('/elections/{election}/finalize-winners', [Admin\ElectionFinalizedWinnerController::class, 'store'])
            ->name('elections.finalize-winners');

        Route::get('/elections/{election}/result', [Admin\ElectionResultController::class, 'show'])
            ->name('elections.result');

        Route::get('/elections/{election}/candidates', function (Election $election) {
            return view('admin.elections.candidates', compact('election'));
        })->name('elections.candidates');
    });
});
