<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Middleware\EnsureEmailVerified;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Guest-only Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');

    Route::get('register', function() {
        return redirect()->route('login')->with('error', 'Public registration is disabled. Please contact the administrator.');
    })->name('register');

    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->middleware('throttle:5,15')
        ->name('password.email');

    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');

    Route::post('reset-password', [ResetPasswordController::class, 'reset'])
        ->middleware('throttle:5,15')
        ->name('password.update');

    // Social authentication.
    Route::get('auth/{provider}', [SocialAuthController::class, 'redirect'])
        ->whereIn('provider', ['google', 'facebook', 'linkedin', 'x'])
        ->middleware('throttle:10,1')
        ->name('auth.social.redirect');

    Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback'])
        ->whereIn('provider', ['google', 'facebook', 'linkedin', 'x'])
        ->middleware('throttle:10,1')
        ->name('auth.social.callback');
});

/*
|--------------------------------------------------------------------------
| Verification Code Page (works for both guests and authenticated users)
|--------------------------------------------------------------------------
*/

Volt::route('verify-code', 'auth.verify-code')
    ->name('verification.verify-code');

Route::post('verify-code/resend', \App\Http\Controllers\VerificationController::class)
    ->middleware('throttle:5,15')
    ->name('verification.resend');

/*
|--------------------------------------------------------------------------
| Authenticated-only
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')
        ->name('password.confirm');
});

Route::middleware(['auth', EnsureEmailVerified::class])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route(
            auth()->user()->dashboardRoute()
        );
    })->name('dashboard');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');
