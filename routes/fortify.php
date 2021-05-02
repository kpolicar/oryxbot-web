<?php

use App\Http\Middleware\Captcha;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Authentication...
Route::get(LaravelLocalization::transRoute('routes.login'), [AuthenticatedSessionController::class, 'create'])
    ->middleware(['guest'])
    ->name('login');

$limiter = config('fortify.limiters.login');

Route::post(LaravelLocalization::transRoute('routes.login'), [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        Captcha::class,
        'guest',
        $limiter ? 'throttle:'.$limiter : null,
    ]));

Route::post(LaravelLocalization::transRoute('routes.logout'), [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Password Reset...
if (Features::enabled(Features::resetPasswords())) {
    Route::get(LaravelLocalization::transRoute('routes.forgot-password'), [PasswordResetLinkController::class, 'create'])
        ->middleware(['guest'])
        ->name('password.request');

    Route::post(LaravelLocalization::transRoute('routes.forgot-password'), [PasswordResetLinkController::class, 'store'])
        ->middleware(['guest', Captcha::class])
        ->name('password.email');

    Route::get(LaravelLocalization::transRoute('routes.reset-password-token'), [NewPasswordController::class, 'create'])
        ->middleware(['guest'])
        ->name('password.reset');

    Route::post(LaravelLocalization::transRoute('routes.reset-password'), [NewPasswordController::class, 'store'])
        ->middleware(['guest'])
        ->name('password.update');
}

// Registration...
if (Features::enabled(Features::registration())) {
    Route::get(LaravelLocalization::transRoute('routes.register'), [RegisteredUserController::class, 'create'])
        ->middleware(['guest'])
        ->name('register');

    Route::post(LaravelLocalization::transRoute('routes.register'), [RegisteredUserController::class, 'store'])
        ->middleware(['guest', Captcha::class]);
}

// Email Verification...
if (Features::enabled(Features::emailVerification())) {
    Route::get(LaravelLocalization::transRoute('routes.email-verify'), [EmailVerificationPromptController::class, '__invoke'])
        ->middleware(['auth'])
        ->name('verification.notice');

    Route::get(LaravelLocalization::transRoute('routes.email-verify-id-hash'), [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post(LaravelLocalization::transRoute('routes.email-verification-notification'), [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');
}

// Profile Information...
if (Features::enabled(Features::updateProfileInformation())) {
    Route::put(LaravelLocalization::transRoute('routes.profile'), [ProfileInformationController::class, 'update'])
        ->middleware(['auth'])
        ->name('user-profile-information.update');
}

