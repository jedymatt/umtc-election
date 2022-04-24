<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ElectionController;
use App\Http\Controllers\Admin\ElectionMonitorController;
use App\Http\Controllers\Admin\ElectionResultController;
use App\Http\Controllers\Admin\ElectionWinnerExportExcelController;
use App\Http\Controllers\Admin\EventCdsgElectionController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventDsgElectionController;
use App\Http\Controllers\Admin\ExportElectionResultController;
use App\Http\Controllers\Admin\MonitorElectionController;
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

    // Routes for authenticated admin
    Route::middleware('auth:admin')->group(function () {
        Route::resource('/admins', AdminController::class)
            ->only(['index', 'create', 'store']);

        Route::resource('/elections', ElectionController::class)
            ->only(['index', 'show']);

        Route::resource('/events.dsg-elections', EventDsgElectionController::class)
            ->only(['create', 'store']);

        Route::resource('/events.cdsg-elections', EventCdsgElectionController::class)
            ->only(['create', 'store']);

        Route::resource('/events', EventController::class)
            ->only(['index', 'show', 'create', 'store']);

        Route::get('/monitor-election/{election}', [MonitorElectionController::class, 'show'])
            ->name('monitor-election');

        Route::get('/elections/{election}/winners/export-excel', [ElectionWinnerExportExcelController::class, 'store'])
            ->name('elections.winners.export-excel');
    });
});
