<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\CustomerCheckoutController;



Route::group(['middleware' => ['auth', 'customer_dropshipper']], function () {
    Route::post('/order/checkout', [CustomerCheckoutController::class, 'CustomerOrderCheckout'])->name('customer.order.checkout');
});

//Customer Dashboard
Route::group(['middleware' => ['auth', 'customer', 'as' => 'customer']], function () {
    Route::get('/customer/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/customer-edit-profile', [DashboardController::class, 'editProfile'])->name('customer.edit.profile');
    Route::post('/customer-update-profile', [DashboardController::class, 'updateProfile'])->name('customer.update.profile');
    Route::get('/customer-password-change', [DashboardController::class, 'passwordChange'])->name('customer.password.change');
    Route::post('/customer-password-update', [DashboardController::class, 'passwordUpdate'])->name('customer.password.update');
    // Payment routes moved to web.php as public (no auth required for guest checkout)
    Route::get('/order-list', [DashboardController::class, 'orderList'])->name('customer.order.list');
    Route::get('/order-details/{id}', [DashboardController::class, 'orderDetails'])->name('customer.order.details');




    //seller route here............
    Route::get('/seller/dashboard', [DashboardController::class, 'sellerDashboard'])->name('seller.customer.dashboard');
    Route::get('/seller-customer-edit-profile', [DashboardController::class, 'sellerEditProfile'])->name('seller.customer.edit.profile');
    Route::post('/seller-customer-update-profile', [DashboardController::class, 'sellerUpdateProfile'])->name('seller.customer.update.profile');
    Route::get('/seller-customer-password-change', [DashboardController::class, 'sellerPasswordChange'])->name('seller.customer.password.change');
    Route::post('/seller-customer-password-update', [DashboardController::class, 'sellerPasswordUpdate'])->name('seller.customer.password.update');

    Route::get('/seller/payment', [DashboardController::class, 'sellerPayment'])->name('seller.customer.payment');
    Route::post('/seller/payment/store', [DashboardController::class, 'sellerPaymentStore'])->name('seller.customer.payment.store');
    Route::get('/seller-order-list', [DashboardController::class, 'sellerOrderList'])->name('seller.customer.order.list');
    Route::get('/seller-order-details/{id}', [DashboardController::class, 'sellerOrderDetails'])->name('seller.customer.order.details');

    //wishlist
    Route::get('wishlist', [WishlistController::class, 'create'])->name('wishlist');
    Route::get('/get-wishlist-product', [WishlistController::class, 'readAllProduct']);
    Route::get('/wishlist-remove/{id}', [WishlistController::class, 'destory']);
});