<?php

use App\Http\Controllers\Customer\AddressBookController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\ExpiredController;
use App\Http\Controllers\Customer\InvoiceController;
use App\Http\Controllers\Customer\PasswordResetController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

Route::prefix('customer')->as('customer.')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', [CustomerProfileController::class, 'index'])->name('index');
        Route::post('/update/{id}', [CustomerProfileController::class, 'update'])->name('update');
    });

    // Password verification routes
    Route::prefix('password')->as('password.')->group(function () {
        Route::get('/verification', [PasswordResetController::class, 'index'])->name('vetification');
        Route::post('/send-code', [PasswordResetController::class, 'sendVerificationCode'])->name('sendVerificationCode');
        Route::post('/verify-code', [PasswordResetController::class, 'verifyCode'])->name('verifyCode');
        Route::get('/password/change/{id}', [PasswordResetController::class, 'create'])->name('create');
        Route::post('/password/update', [PasswordResetController::class, 'update'])->name('update');


        Route::prefix('expired')->as('expired.')->group(function () {
            Route::get('/', [ExpiredController::class, 'index'])->name('index');
            Route::get('/invalid', [ExpiredController::class, 'invalidCode'])->name('invalidCode');
        });
    });

    // Address book routes
    Route::prefix('address-book')->as('addressBook.')->group(function () {
        Route::get('/', [AddressBookController::class, 'index'])->name('index');
        Route::post('/store', [AddressBookController::class,'store'])->name('store');
        Route::get('/edit/{id}', [AddressBookController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AddressBookController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AddressBookController::class, 'destroy'])->name('destroy');
        Route::post('/default/address/{id}', [AddressBookController::class, 'defaultAddress'])->name('defaultAddress');
    });

    // Order Routes
    Route::prefix('order')->as('order.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/view', [InvoiceController::class, 'invoiceView'])->name('invoice.view');
        Route::post('/store', [InvoiceController::class,'store'])->name('store');
        Route::get('/track/package', [InvoiceController::class, 'trackPackage'])->name('track.package');
    });








});
