<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\PageSettingsController;
use App\Http\Controllers\Admin\PartnershipController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VariantOptionsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users routes
    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Categories routes
    Route::prefix('categories')->as('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/store', [CategoryController::class,'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::delete('/delete/image/{id}', [CategoryController::class, 'removeImage'])->name('removeImage');
    });

    // Sub Categories routes
    Route::prefix('subcategories')->as('subcategories.')->group(function () {
        Route::get('/', [SubcategoryController::class, 'index'])->name('index');
        Route::post('/store', [SubcategoryController::class,'store'])->name('store');
        Route::get('/edit/{id}', [SubcategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [SubcategoryController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [SubcategoryController::class, 'destroy'])->name('destroy');
        Route::delete('/delete/image/{id}', [SubcategoryController::class, 'removeImage'])->name('removeImage');
    });

    // Child Categories routes
    Route::prefix('childcategories')->as('childcategories.')->group(function () {
        Route::get('/', [ChildCategoryController::class, 'index'])->name('index');
        Route::post('/store', [ChildCategoryController::class,'store'])->name('store');
        Route::get('/edit/{id}', [ChildCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ChildCategoryController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ChildCategoryController::class, 'destroy'])->name('destroy');
    });

    // Order routes
    Route::prefix('orders')->as('orders.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/single/user/view/{id}', [InvoiceController::class, 'singleUserView'])->name('userView');
        Route::get('/single/invoice/view/{id}', [InvoiceController::class, 'singleInvoiceView'])->name('invoiceView');
        Route::post('/update/status/{id}', [InvoiceController::class, 'updateStatus'])->name('updateStatus');
        // Route::delete('/destroy/{id}', [InvoiceController::class, 'destroy'])->name('destroy');
    });

    // Partnership routes

    // Product routes
    Route::prefix('products')->as('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class,'store'])->name('store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::get('/single/view/{id}', [ProductController::class, 'singleView'])->name('singleView');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::delete('/remove/image/{id}', [ProductController::class,'removeImage'])->name('removeImage');
        Route::delete('/remove/featured/image/{id}', [ProductController::class,'removeFeaturedImage'])->name('removeFeaturedImage');

        Route::get('/stock', [StockController::class, 'index'])->name('stock');

        // Brands routes
        Route::prefix('variants')->as('variants.')->group(function () {
            Route::get('/', [VariantOptionsController::class, 'index'])->name('index');
            Route::post('/store', [VariantOptionsController::class,'store'])->name('store');
            Route::get('/edit/{id}', [VariantOptionsController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [VariantOptionsController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [VariantOptionsController::class, 'destroy'])->name('destroy');
        });
        // Brands routes
        Route::prefix('brands')->as('brands.')->group(function () {
            Route::get('/', [BrandController::class, 'index'])->name('index');
            Route::post('/store', [BrandController::class,'store'])->name('store');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [BrandController::class, 'Update'])->name('update');
            Route::delete('/destroy/{id}', [BrandController::class, 'destroy'])->name('destroy');
        });

    });

    // Order routes

    // Settings routes
    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/general/settings', [SettingsController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        Route::post('/general/settings', [SettingsController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        Route::post('/remove', [SettingsController::class, 'removeImage'])->name('removeImage');

        // Page Settings routes
        Route::prefix('pages')->as('pages.')->group(function () {
            Route::get('/', [PageSettingsController::class, 'index'])->name('index');
            Route::post('/store/homepage/banner', [PageSettingsController::class,'storeHomepageBanner'])->name('store.homePageBanner');
            Route::post('/store/banner1', [PageSettingsController::class,'storeAdsBanner1'])->name('store.banner1');
            Route::post('/store/banner2', [PageSettingsController::class,'storeAdsBanner2'])->name('store.banner2');
            Route::post('/store/banner3', [PageSettingsController::class,'storeAdsBanner3'])->name('store.banner3');
            Route::post('/store/banner4', [PageSettingsController::class,'storeAdsBanner4'])->name('store.banner4');
            Route::post('/store/socials', [PageSettingsController::class,'storeOrUpdateSocialMedia'])->name('storeOrUpdate');
            Route::delete('/destroy/{id}', [PageSettingsController::class, 'removeBanner'])->name('removeBanner');
        });

        // Delivery routes
        Route::prefix('delivery')->as('delivery.')->group(function () {
            Route::get('/', [DeliveryController::class, 'index'])->name('index');
            Route::post('/store', [DeliveryController::class,'store'])->name('store');
            Route::get('/edit/{id}', [DeliveryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [DeliveryController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [DeliveryController::class, 'destroy'])->name('destroy');
        });

        // Notice routes
        Route::prefix('notices')->as('notices.')->group(function () {
            Route::get('/', [NoticeController::class, 'index'])->name('index');
            Route::post('/store', [NoticeController::class,'store'])->name('store');
            Route::get('/edit/{id}', [NoticeController::class,'edit'])->name('edit');
            Route::post('/update/{id}', [NoticeController::class,'update'])->name('update');
            Route::delete('/destroy/{id}', [NoticeController::class, 'destroy'])->name('destroy');
            Route::delete('/remove/video/{id}', [NoticeController::class, 'removeVideo'])->name('removeVideo');
        });

        // Partnership routes
        Route::prefix('partnerships')->as('partnerships.')->group(function () {
            Route::get('/', [PartnershipController::class, 'index'])->name('index');
            Route::post('/store', [PartnershipController::class,'store'])->name('store');
            Route::get('/edit/{id}', [PartnershipController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [PartnershipController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [PartnershipController::class, 'destroy'])->name('destroy');
            Route::delete('/remove/image/{id}', [PartnershipController::class,'removeImage'])->name('removeImage');
        });

        // Payment Method routes
        Route::prefix('payment-methods')->as('paymentMethods.')->group(function () {
            Route::get('/', [PaymentMethodController::class, 'index'])->name('index');
            Route::post('/store', [PaymentMethodController::class,'store'])->name('store');
            Route::get('/edit/{id}', [PaymentMethodController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [PaymentMethodController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [PaymentMethodController::class, 'destroy'])->name('destroy');
            Route::delete('/delete/image/{id}', [PaymentMethodController::class, 'removeImage'])->name('removeImage');
        });

        // Country routes
        Route::prefix('countries')->as('countries.')->group(function () {
            Route::get('/', [CountryController::class, 'index'])->name('index');
            Route::get('/edit/{id}', [CountryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CountryController::class, 'update'])->name('update');
            // Route::delete('/destroy/{id}', [CountryController::class, 'destroy'])->name('destroy');
        });

    });

    // Services routes
    Route::prefix('services')->as('services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::post('/store', [ServiceController::class,'store'])->name('store');
        Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ServiceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('delivery-agents')->as('deliveryAgents.')->group(function () {

        Route::get('/', [AgentController::class, 'index'])->name('index');
        Route::post('/store', [AgentController::class,'store'])->name('store');
        Route::get('/edit/{id}', [AgentController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AgentController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [AgentController::class, 'destroy'])->name('destroy');
        Route::delete('/delete/image/{id}', [AgentController::class, 'removeImage'])->name('removeImage');
    });


});





