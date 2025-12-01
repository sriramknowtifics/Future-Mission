<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLER IMPORTS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CRM\TicketController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ServicePublicController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Vendor\ServiceController;
use App\Http\Controllers\Finance\FinanceController;

use App\Http\Controllers\Auth\VerificationController;

use App\Http\Controllers\Delivery\DeliveryController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VendorRegisterController;
use App\Http\Controllers\Admin\ProductApprovalController;
use App\Http\Controllers\Admin\ServiceApprovalController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;



/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('products.show');

//Service
Route::get('/service', [ServicePublicController::class, 'index'])->name('service.index');
Route::get('/service/{service}', [ServicePublicController::class, 'show'])->name('service.show');

//Service orders
Route::post('/service_orders/store', [ServiceOrderController::class, 'store'])->name('service.orders.store');
Route::post('/service_orders/confirm', [ServiceOrderController::class, 'confirm'])
     ->name('service.orders.confirm');
Route::get('/service_orders/{order}', [ServiceOrderController::class, 'show'])
->name('service.orders.show');

Route::post('/service_orders/{order}', [ServiceOrderController::class, 'destroy'])
->name('service.orders.destroy');


// CMS Pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');
Route::view('/wishlist', 'wishlist')->name('wishlist.index');

// Cart
// Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
// Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
// Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
use App\Http\Controllers\WishlistController;

// Route::middleware(['auth'])->group(function () {

    // Show wishlist page
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

    // Add product to wishlist
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');

    // Remove a specific wishlist item
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
// });

  Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
  Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
  Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
  Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
  Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Category AJAX
Route::get('/categories/{id}/subcategories', function ($id) {
  return \App\Models\Category::where('parent_id', $id)->get(['id', 'name']);
})->name('categories.sub');


/*
|--------------------------------------------------------------------------
| CHECKOUT (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
  Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
});


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/register/vendor', [VendorRegisterController::class, 'showRegistrationForm'])->name('register.vendor');
Route::post('/register/vendor', [VendorRegisterController::class, 'register'])->name('register.vendor.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Email verification
Route::get('/email/verify', [VerificationController::class, 'notice'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->middleware(['auth', 'throttle:3,1'])->name('verification.resend');

// Password reset
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


/*
|--------------------------------------------------------------------------
| CUSTOMER / BUYER ACCOUNT
|--------------------------------------------------------------------------
Route::middleware(['auth', 'verified', 'role:customer|vendor|admin'])

*/
Route::middleware(['auth', 'verified', 'role:customer'])
  ->prefix('account')
  ->name('account.')
  ->group(function () {

    Route::get('/dashboard', [AccountController::class, 'index'])->name('dashboard');
    Route::post('/update', [AccountController::class, 'updateAccount'])
    ->name('update');

    Route::get('/orders/{order}', [AccountController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [AccountController::class, 'cancelOrder'])->name('orders.cancel');


  });


/*
|--------------------------------------------------------------------------
| VENDOR AREA (ROLE: vendor)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:vendor'])
  ->prefix('vendor')
  ->name('vendor.')
  ->group(function () {

    // Vendor dashboard
    Route::get('/dashboard', function () {
      return view('vendor.dashboard');
    })->name('dashboard');

    // Preview
    Route::post('/products/preview', [VendorProductController::class, 'preview'])->name('products.preview');

    // Vendor Product CRUD (THIS DEFINES vendor.products.index)
    Route::resource('/products', VendorProductController::class);
     Route::resource('/services',ServiceController::class);
  });


/*
|--------------------------------------------------------------------------
| ADMIN AREA (ROLE: admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('service_categories', ServiceCategoryController::class);

    Route::resource('brands', BrandController::class);

    // Product approvals
    Route::get('products/pending', [ProductApprovalController::class, 'index'])->name('products.pending');
    Route::post('products/{product}/approve', [ProductApprovalController::class, 'approve'])->name('products.approve');
    Route::post('products/{product}/reject', [ProductApprovalController::class, 'reject'])->name('products.reject');
    Route::get('products', [ProductApprovalController::class, 'indexAll'])->name('products.index');

     Route::get('services/pending', [ServiceApprovalController::class, 'index'])->name('services.pending');
    Route::post('services/{service}/approve', [ServiceApprovalController::class, 'approve'])->name('services.approve');
    Route::post('services/{service}/reject', [ServiceApprovalController::class, 'reject'])->name('services.reject');
    Route::get('/services', [ServiceApprovalController::class, 'indexAll'])->name('services.index');

    // Banners
     Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
  });


/*
|--------------------------------------------------------------------------
| DELIVERY PARTNER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:delivery'])
  ->prefix('delivery')
  ->name('delivery.')
  ->group(function () {

    Route::get('/', [DeliveryController::class, 'index'])->name('index');
    Route::post('/assignment/{assignment}/accept', [DeliveryController::class, 'accept'])->name('accept');
    Route::post('/assignment/{assignment}/status', [DeliveryController::class, 'updateStatus'])->name('status');
  });


/*
|--------------------------------------------------------------------------
| FINANCE TEAM
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:finance'])
  ->prefix('finance')
  ->name('finance.')
  ->group(function () {

    Route::get('/', [FinanceController::class, 'index'])->name('index');
    Route::get('/vendor/{vendor}/settlements', [FinanceController::class, 'viewVendorSettlements'])->name('vendor.settlements');
    Route::post('/settlement/{transaction}/approve', [FinanceController::class, 'approveSettlement'])->name('settlement.approve');
  });


/*
|--------------------------------------------------------------------------
| CRM TEAM
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:crm'])
  ->prefix('crm')
  ->name('crm.')
  ->group(function () {

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/respond', [TicketController::class, 'respond'])->name('tickets.respond');
  });
