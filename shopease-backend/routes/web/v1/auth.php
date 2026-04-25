<?php

use App\Http\Controllers\Web\V1\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Web\V1\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Web\V1\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Web\V1\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Web\V1\Auth\NewPasswordController;
use App\Http\Controllers\Web\V1\Auth\PasswordController;
use App\Http\Controllers\Web\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Web\V1\Auth\RegisteredUserController;
use App\Http\Controllers\Web\V1\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

});

Route::middleware('auth')->group(function () {

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
