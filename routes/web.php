<?php


use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ShopController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/category/{slug}', [ShopController::class, 'categoryShow'])->name('category.show');
Route::get('/subcategory/{slug}/', [ShopController::class, 'subcategoryShow'])->name('subcategory.show');
Route::get('/childcategory/{slug}', [ShopController::class, 'childcategoryShow'])->name('childcategory.show');
Route::get('/product/{slug}', [ShopController::class, 'productShow'])->name('product.show');

// cart routes prefix
Route::prefix('cart')->as('cart.')->group(function () {
    Route::get('/', [CartController::class, 'getCartItems'])->name('index');
    Route::get('/auth/check', [CartController::class, 'authCheck'])->name('auth.check');
    Route::post('/store', [CartController::class, 'addToCart'])->name('store');
    Route::post('/increment/{id}', [CartController::class, 'increment'])->name('increment');
    Route::post('/decrement/{id}', [CartController::class, 'decrement'])->name('decrement');
    Route::delete('/remove/{id}', [CartController::class, 'removeItem'])->name('remove');
});

// chackout routes
Route::prefix('checkout')->as('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/store', [CheckoutController::class,'store'])->name('store');
    Route::post('/change/status/{id}', [CheckoutController::class,'changeStatus'])->name('change.status');
    Route::get('/get-selected-address', [CheckoutController::class, 'getSelectedAddress'])->name('get.selected.address');

});



Route::prefix('ajax')->as('ajax.')->group(function () {
    Route::get('get/country', [AjaxController::class, 'getCountry'])->name('get.country');
    Route::get('get/division', [AjaxController::class, 'getDivisions'])->name('get.division');
    Route::get('get/district/{division}', [AjaxController::class, 'getDistricts'])->name('get.district');
    Route::get('get/upazila/{district}', [AjaxController::class, 'getUpazilas'])->name('get.upazila');
    Route::get('get/union/{upazila}', [AjaxController::class, 'getUnions'])->name('get.union');


    Route::get('/get/banner/{id}', [AjaxController::class, 'getBanners'])->name('get.banners');
    Route::get('/get/brand', [AjaxController::class, 'getBrand'])->name('get.brand');
    Route::get('/get/delivery/type', [AjaxController::class, 'deliveryType'])->name('get.delivery_type');
    Route::get('/get/category', [AjaxController::class, 'getCategory'])->name('get.category');
    Route::get('/get/subcategory/{id}', [AjaxController::class, 'getSubCategory'])->name('get.subCategory');
    Route::get('/get/childcategory/{id}', [AjaxController::class, 'getchildCategory'])->name('get.childCategory');
    Route::get('/get/all/subcategory', [AjaxController::class, 'getAllSubCategory'])->name('get.allSubCategory');
    Route::get('/get/products', [AjaxController::class, 'getProducts'])->name('get.products');
    Route::get('/get/colorfamily/{id}', [AjaxController::class, 'getColorFamily'])->name('get.colorFamily');
    Route::get('/get/price/{id}', [AjaxController::class, 'getProductsPrice'])->name('get.product.price');
    Route::post('/get/product/variant/options', [AjaxController::class, 'getProductsvariantOptions'])->name('get.product.variant.options');
    Route::get('/get/product/variant/options/data/{id}', [AjaxController::class, 'getProductsvariantOptionsData'])->name('get.product.variant.options.data');
});

// Show email verification notice
Route::get('/email/verify', function (Request $request) {
    return view('customer.auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Email verification link handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/customer/dashboard'); // Redirect after verification
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification email
Route::post('/email/resend', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/customer/dashboard');
    }

    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'A new verification link has been sent to your email.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


require __DIR__.'/customer.php';
require __DIR__.'/admin.php';
require __DIR__.'/adminAuth.php';
