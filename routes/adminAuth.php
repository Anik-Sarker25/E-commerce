<?php

use App\Http\Controllers\AdminAuth\AdminAuthController;
use App\Http\Controllers\AdminAuth\PasswordResetController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');


    Route::get('/register', [AdminAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register']);

    Route::get('/password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

});



