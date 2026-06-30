<?php

use App\Http\Controllers\AddToCartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\AreaController;

use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Frontend\CartController;

use App\Http\Controllers\Backend\ProductController;

use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\SellerController;

use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\TrackingController;


use App\Http\Controllers\Frontend\SellerShopController;


use App\Http\Controllers\CustomerCheckoutController;
use App\Http\Controllers\Frontend\BkashPaymentGatewayController;
use App\Http\Controllers\OtpVerifyController;
use App\Http\Controllers\Seller\ReportController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Frontend\SitemapController;

// Dynamic Sitemap (replaces static sitemap.xml)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/
//Route::get('test', [TestController::class, 'index']);


// Fontend Routes


Route::get('language/bangla', [LanguageController::class, 'bangla'])->name('bangla.language');
Route::get('language/english', [LanguageController::class, 'english'])->name('english.language');

// ── Seller Share Link (Ref Tracking) ─────────────────────────────────
// /ref/SELLERCODE → store seller ID in session → 10% commission on order delivery
Route::get('/ref/{code}', function ($code) {
    $seller = \App\Models\User::where('refer_code', $code)
        ->whereIn('usertype', ['seller', 'vendor'])
        ->where('status', 1)
        ->where('payment_status', 1)
        ->first();
    if ($seller) {
        session(['seller_ref_code' => $code, 'seller_ref_id' => $seller->id]);
    }
    return redirect(request('redirect', '/'));
})->name('seller.ref.track');
Route::get('/success', [FrontendController::class, 'SuccessPage'])->name('success.page');
Route::get('/cancel', [FrontendController::class, 'CancelPage'])->name('cancel.page');
Route::get('/failed', [FrontendController::class, 'FaildPage'])->name('failed.page');


Route::get('/cache-clear', function () {
    if (!auth()->check() || auth()->user()->usertype !== 'admin') {
        abort(403, 'Unauthorized');
    }
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('clear-compiled');
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');
    Artisan::call('optimize');
    session()->flash('message', 'System Updated Successfully.');
    return redirect()->route('frontend.home');
});

Route::get('/get-product-price', [FrontendController::class, 'getPrice'])
    ->name('get.product.price');



Route::get('/', [FrontendController::class, 'index'])->name('frontend.home')->middleware('cache.response:120');

Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about.us')->middleware('cache.response:600');
Route::get('/bkash/payment', [BkashPaymentGatewayController::class, 'BkashPaymentCreate'])->name('bkash.create');
Route::get('/privacy-policy', [FrontendController::class, 'privacyPlicy'])->name('privacy.policy');
Route::get('/return-policy', [FrontendController::class, 'returnPlicy'])->name('return.policy');
Route::get('/terms-and-condition', [FrontendController::class, 'termsAndCondition'])->name('terms.and.condition');
Route::get('/contact-us', [FrontendController::class, 'contactUs'])->name('contact.us');
Route::get('/user-guide', [FrontendController::class, 'userGuide'])->name('user.guide');
Route::post('/communication-store', [FrontendController::class, 'communicationStore'])->name('communication.store');
Route::get('/product-list', [FrontendController::class, 'productList'])->name('product.list')->middleware('cache.response:60');
Route::post('shop-filter', [FrontendController::class, 'shopFilter'])->name('shop.filter');

Route::get('/hot-deals', [FrontendController::class, 'hotDeals'])->name('hot.deals');
Route::get('/speacial-offers', [FrontendController::class, 'speacialOffers'])->name('speacial.offers');
Route::get('/pricing', [FrontendController::class, 'pricingCards'])->name('pricing.cards');

Route::get('/category-wise-product/{category_id}', [FrontendController::class, 'categoryWiseProduct'])->name('category.wise.product');
Route::post('category-wise-filter/{category_id}', [FrontendController::class, 'categoryWiseFilter'])->name('category.wise.filter');
Route::get('/brand-wise-product/{brand_id}', [FrontendController::class, 'brandWiseProduct'])->name('brand.wise.product');
Route::get('/product-details/{slug}', [FrontendController::class, 'productDetails'])->name('product.details.info');
Route::get('/shopping-cart', [FrontendController::class, 'shoppingCart'])->name('shopping.cart');
Route::post('/get-variant-price', [FrontendController::class, 'getVariantPrice'])->name('product.getVariantPrice');


//Shopping-

Route::post('/add-cart', [CartController::class, 'addCart'])->name('add.cart');
Route::get('/show-cart', [CartController::class, 'showCart'])->name('show.cart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('update.cart');
Route::get('/delete-cart/{rowId}', [CartController::class, 'deleteCart'])->name('delete.cart');



//Seller Shopping-Cart
Route::post('/add-seller-cart', [CartController::class, 'addSellerCart'])->name('add.seller.cart');
Route::get('/show-seller-cart', [CartController::class, 'showSellerCart'])->name('show.seller.cart');
Route::post('/update-seller-cart', [CartController::class, 'updateSellerCart'])->name('update.seller.cart');
Route::get('/delete-seller-cart/{rowId}', [CartController::class, 'deleteSellerCart'])->name('delete.seller.cart');

// New courier routes
Route::post('orders/courier/assign', [OrderController::class, 'assignCourier'])->name('courier.assign');
Route::post('orders/courier/bulk-assign', [OrderController::class, 'bulkAssignCourier'])->name('courier.bulk.assign');
Route::post('orders/courier/track', [OrderController::class, 'trackCourierOrder'])->name('courier.track');
Route::get('courier/cities', [OrderController::class, 'getCourierCities'])->name('courier.cities');
Route::get('courier/zones', [OrderController::class, 'getCourierZones'])->name('courier.zones');

Route::get('/orders/courier/list', [OrderController::class, 'courierOrders'])->name('orders.courier.list');
Route::get('/orders/courier/data', [OrderController::class, 'courierOrdersData'])->name('orders.courier.data');


// seller add to cart
Route::post('/cart/seller/data/store/{id}', [CartController::class, 'addToSellerCart']);

// add to cart
Route::post('/cart/data/store/{id}', [CartController::class, 'addToCart']);

Route::prefix('cart')->as('cart.')->group(function () {
    Route::prefix('customer')->as('customer.')->group(function () {
        Route::get('data', [AddToCartController::class, 'customerCartData'])->name('customerCartData');
        Route::post('store', [AddToCartController::class, 'customerCartStore'])->name('customerCartStore');
        Route::get('destroy/{cart_id}', [AddToCartController::class, 'customerCartDestroy'])->name('customerCartDestroy');
        Route::post('update', [AddToCartController::class, 'customerCartUpdate'])->name('customerCartUpdate');
    });
});

// add to wishlist
Route::post('/add_to_wishlist/{product_id}', [CartController::class, 'addToWishlist']);

//product view modal with ajax
Route::get('product/view/modal/{id}', [FrontendController::class, 'productViewAjax']);


//Coupon Apply
Route::post('/save-coupon', [CartController::class, 'saveCoupon'])->name('save.coupon');
Route::post('/seller/save-coupon', [CartController::class, 'SellerSaveCoupon'])->name('seller.save.coupon');
// Save Area ID
Route::get('/save-area-id', [CartController::class, 'saveAreaId']);
Route::get('/get-variant-price', [ProductController::class, 'getVariantPrice'])->name('get.variant.price');
//Customer Dashboard
Route::get('/customer-login', [CheckoutController::class, 'customerLogin'])->name('customer.login');
Route::get('/customer-otp', [CheckoutController::class, 'SendCustomerOtp'])->name('send.otp');
Route::post('/customer-otp/save', [CheckoutController::class, 'SendCustomerOtpSubmit'])->name('send.customer.otp');
// Customer signup disabled — guest checkout used instead
Route::get('/customer-signup', [CheckoutController::class, 'customerSignup'])->name('customer.signup');
Route::post('/signup-store', [CheckoutController::class, 'signupStore'])->name('signup.store');
Route::get('/email-verify', [CheckoutController::class, 'emailVerify'])->name('email.verify');
//Route::post('/verify-store', [CheckoutController::class, 'verifyStore'])->name('verify.store');
Route::get('/checkout', [CheckoutController::class, 'checkOut'])->name('customer.checkout');
Route::post('/checkout/store', [CheckoutController::class, 'checkoutStore'])->name('customer.checkout.store');

// Payment page - public (no auth required, supports both guest and logged-in customers)
Route::get('/payment', [\App\Http\Controllers\Frontend\DashboardController::class, 'payment'])->name('customer.payment');
Route::post('/payment/store', [\App\Http\Controllers\Frontend\DashboardController::class, 'paymentStore'])->name('customer.payment.store');
Route::post('/guest/order/checkout', [CustomerCheckoutController::class, 'CustomerOrderCheckout'])->name('guest.order.checkout');
Route::get('/guest-order-confirmation/{order}', [CustomerCheckoutController::class, 'guestOrderConfirmation'])
    ->name('guest.order.confirmation')
    ->middleware('signed');

Route::get('/subcategory-wise-product/{subcategory_id}', [FrontendController::class, 'subcategoryWiseProduct'])->name('subcategory.wise.product');

Route::get('/logout2', [CheckoutController::class, 'logout2'])->name('logout2');


Route::prefix('/verify')->as('verify.')->group(function () {
    Route::get('/otp/{id}', [OtpVerifyController::class, 'index'])->name('index');
    Route::post('/store/{id}', [OtpVerifyController::class, 'store'])->name('store');
});

//seller code here...........
// Route::get('/seller-customer-login', [CheckoutController::class, 'sellerCustomerLogin'])->name('seller.customer.login');
// Route::get('/seller-customer-signup', [CheckoutController::class, 'sellerCustomerSignup'])->name('seller.customer.signup');
// Route::post('/seller-signup-store', [CheckoutController::class, 'sellerSignupStore'])->name('seller.signup.store');
Route::get('/seller-email-verify', [CheckoutController::class, 'sellerOtpVerify'])->name('seller.email.verify');
Route::get('/seller-verify', [CheckoutController::class, 'sellerVerify'])->name('seller.a.verify');
Route::post('/seller-account-verifies', [CheckoutController::class, 'sellerVerifyOtp'])->name('seller.verify.account_otp');
Route::post('/seller-verify/a', [CheckoutController::class, 'sellerVerifyKafi'])->name('seller.verify.a');

Route::get('/seller/checkout', [CheckoutController::class, 'sellerCheckOut'])->name('seller.customer.checkout');
Route::post('/seller/checkout/store', [CheckoutController::class, 'sellerCheckoutStore'])->name('seller.customer.checkout.store');

//Seller Dashboard
// Route::get('/seller/login', [SellerController::class, 'sellerLogin'])->name('seller.login');
// Route::post('/seller-login/store', [SellerController::class, 'sellerLoginSave'])->name('seller.login.store');
Route::get('/seller_forget_password', [SellerController::class, 'sellerForgetPassword'])->name('seller.forget_password');
Route::post('/seller_forget_passwords', [SellerController::class, 'seller_forget_passwordSave'])->name('seller.forgetpassword.save');
Route::get('/seller/signup', [SellerController::class, 'sellerSignup'])->name('seller.signup');
Route::post('/seller-store', [SellerController::class, 'sellerStore'])->name('seller.store');
Route::get('/get_seller_with_gmail_verify', [SellerController::class, 'sellerAccountVerifyCode'])->name('seller_email.get');
Route::post('/seller_with_gmail_verify_code/save', [SellerController::class, 'sellerEmailVerifyCodeSave'])->name('seller_emailverification.code');
Route::get('/account-verify', [SellerController::class, 'sellerOtp'])->name('seller_otp');
Route::post('/seller-verify-store', [SellerController::class, 'sellerVerifyStore'])->name('seller.verify.stored');

Route::prefix('shops')->group(function () {
    $shopID = Request::segment(2);
    Route::get($shopID, [SellerShopController::class, 'shop'])->name('shop');
    Route::get('{shopID}/seller/home/', [SellerShopController::class, 'homepageShop'])->name('seller.home');
    Route::get('{shopID}/{category_id}/seller_category/shop/', [SellerShopController::class, 'ShopCategoryPage'])->name('seller.shop.category');
    Route::get('/seller-product-details/{slug}/{shopID}', [SellerShopController::class, 'sellerProductDetails'])->name('seller.product.details');
});

//Api
Route::get('location/ajax/{division_id}', [AreaController::class, 'locationAjax'])->name('location.ajax');
Route::get('sublocation/ajax/{location_id}', [AreaController::class, 'sublocationAjax'])->name('sublocation.ajax');
Route::get('area/ajax/{sub_location_id}', [AreaController::class, 'areaAjax'])->name('area.ajax');

//LARAVEL SOCIATLITE
//login google
Route::post('userlogin', [LoginController::class, 'Userlogin'])->name('userlogin');
Route::get('forget/email', [LoginController::class, 'ForgetEmailID'])->name('forget.email');
Route::post('forget/email', [LoginController::class, 'forgetEmailVerify'])->name('forget.email_verify');
Route::post('/ajax-check-coupon', [\App\Http\Controllers\Frontend\CartController::class, 'ajaxCheckCouponForRegistration'])->name('ajax.check.coupon');
Route::post('/ajax-apply-coupon', [\App\Http\Controllers\Frontend\CartController::class, 'ajaxApplyCoupon'])->name('ajax.apply.coupon');
Route::get('/remove-coupon', [\App\Http\Controllers\Frontend\CartController::class, 'removeCoupon'])->name('remove.coupon');

Route::post('/update-delivery-charge', [\App\Http\Controllers\Frontend\FrontendController::class, 'updateDeliveryCharge'])->name('update.delivery.charge');

Route::get('forget/verify/otp', [LoginController::class, 'VerifyEmailAndOtp'])->name('forget.verify.otp');
Route::post('/forget/otp/resend', [LoginController::class, 'resendForgotOtp'])->name('forget.otp.resend');
Route::post('forget/verify/otp', [LoginController::class, 'VerifyEmailAndOtpSave'])->name('forget.verify.otp');
Route::get('password_changes/with/email/', [LoginController::class, 'VerifyEmailAndPasswordChange'])->name('forget_password');
Route::post('password_changes_with/email/', [LoginController::class, 'VerifyEmailAndPasswordChangeSave'])->name('otp.password_change');
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);
//facebook
Route::get('login/facebook', [LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [LoginController::class, 'handleFacebookCallback']);

//Order Tracking
Route::get('order/track/{id?}', [TrackingController::class, 'orderTrackNow'])->name('order.track'); // supports ?invoice=USP00044
Route::post('order/invoice/track/submit', [TrackingController::class, 'orderTrackSubmit'])->name('order.tracksave');
Route::get('/bkash/callback', [BkashPaymentGatewayController::class, 'callback'])->name('bkash.callback');
//search product
Route::get('/search-products', [SearchController::class, 'searchProduct'])->name('search.product');
Route::post('/find-products', [SearchController::class, 'findProducts'])->name('find.product');
Auth::routes();
Route::post('dropshipper/order/checkout', [CustomerCheckoutController::class, 'DropshipperOrderCheckout'])->name('dropshipper.order.checkout');
