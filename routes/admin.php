<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\AreaController;
use App\Http\Controllers\Backend\LogoController;
use App\Http\Controllers\Backend\SizeController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\AdminReportController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\UsersController;

use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\DropshipperController;
use App\Http\Controllers\Backend\WalletController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SettingController;

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CustomerController;

use App\Http\Controllers\Backend\BannerImageController;
use App\Http\Controllers\Backend\ColorSettingController;
use App\Http\Controllers\Backend\CommissionSettingController;

use App\Http\Controllers\Backend\SubcategoryController;

use App\Http\Controllers\Backend\ManageSellerController;

use App\Http\Controllers\Backend\PaymentGatewayController;
use App\Http\Controllers\Backend\SellerDashboardController;

use App\Http\Controllers\Backend\CourierController;



//Admin Dashboard
Route::post('/adminlogin', [LoginController::class, 'Adminlogin'])->name('adminlogin');
Route::post('/adminlogin/logout', [LoginController::class, 'AdminLogout'])->name('adminlogin.logout');
Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::resource('couriers', CourierController::class);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::prefix('users')->group(function () {
        Route::get('/view', [UsersController::class, 'view'])->name('users.view');
        Route::get('/list', [UsersController::class, 'list'])->name('users.list');
        Route::get('/add', [UsersController::class, 'add'])->name('users.add');
        Route::post('/store', [UsersController::class, 'store'])->name('users.store');
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::post('/update/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::get('/delete/{id}', [UsersController::class, 'delete'])->name('users.delete');
    });

    Route::prefix('profiles')->group(function () {
        Route::get('/view', [ProfileController::class, 'view'])->name('profiles.view');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
        Route::post('/store', [ProfileController::class, 'update'])->name('profiles.update');
        Route::get('/password/view', [ProfileController::class, 'passwordView'])->name('profiles.password.view');
        Route::post('/password/update', [ProfileController::class, 'passwordUpdate'])->name('profiles.password.update');
    });

    Route::prefix('logos')->group(function () {
        Route::get('/view', [LogoController::class, 'view'])->name('logos.view');
        Route::get('/add', [LogoController::class, 'add'])->name('logos.add');
        Route::post('/store', [LogoController::class, 'store'])->name('logos.store');
        Route::get('/edit/{id}', [LogoController::class, 'edit'])->name('logos.edit');
        Route::post('/update/{id}', [LogoController::class, 'update'])->name('logos.update');
        Route::post('/delete', [LogoController::class, 'delete'])->name('logos.delete');
    });
    Route::prefix('subscriptions')->group(function () {
        Route::get('/view', [SellerDashboardController::class, 'viewSubcription'])->name('subscriptions.view');
        Route::get('/add', [SellerDashboardController::class, 'addSubscription'])->name('subscriptions.add');
        Route::post('/store', [SellerDashboardController::class, 'storeSubscription'])->name('subscriptions.store');
        Route::get('/edit/{id}', [SellerDashboardController::class, 'editSubscription'])->name('subscriptions.edit');
        Route::post('/update/{id}', [SellerDashboardController::class, 'updateSubscription'])->name('subscriptions.update');
        Route::get('/delete/{id}', [SellerDashboardController::class, 'deleteSubscription'])->name('subscriptions.delete');
    });
    Route::prefix('banners')->group(function () {
        Route::get('/view', [BannerImageController::class, 'view'])->name('banners.view');
        Route::get('/edit/{id}', [BannerImageController::class, 'edit'])->name('banners.edit');
        Route::post('/update/{id}', [BannerImageController::class, 'update'])->name('banners.update');
    });
    Route::prefix('paymentgatways')->group(function () {
        Route::get('/view', [PaymentGatewayController::class, 'view'])->name('paymentgatways.view');
        Route::get('/add', [PaymentGatewayController::class, 'add'])->name('paymentgatways.add');
        Route::post('/store', [PaymentGatewayController::class, 'store'])->name('paymentgatways.store');
        Route::get('/edit/{id}', [PaymentGatewayController::class, 'edit'])->name('paymentgatways.edit');
        Route::post('/update/{id}', [PaymentGatewayController::class, 'update'])->name('paymentgatways.update');
    });

    Route::prefix('smsgateways')->group(function () {
        Route::get('/view', [\App\Http\Controllers\Backend\SmsGatewayController::class, 'index'])->name('smsgateways.view');
        Route::get('/test', [\App\Http\Controllers\Backend\SmsGatewayController::class, 'testPage'])->name('smsgateways.test.page');
        Route::get('/add', [\App\Http\Controllers\Backend\SmsGatewayController::class, 'create'])->name('smsgateways.add');
        Route::post('/store', [\App\Http\Controllers\Backend\SmsGatewayController::class, 'store'])->name('smsgateways.store');
        Route::post('/test-send', [\App\Http\Controllers\Backend\SmsGatewayController::class, 'testSend'])->name('smsgateways.test');
        Route::get('/templates', [\App\Http\Controllers\Backend\SmsGatewayController::class, 'templates'])->name('sms.templates.view');
        Route::put('/templates/update', [\App\Http\Controllers\Backend\SmsGatewayController::class, 'updateTemplates'])->name('sms.templates.update');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\SmsGatewayController::class, 'edit'])->name('smsgateways.edit');
        Route::post('/update/{id}', [
            \App\Http\Controllers\Backend\SmsGatewayController::class,
            'update'
        ])->name('smsgateways.update');
    });
    Route::prefix('sliders')->group(function () {
        Route::get('/view', [SliderController::class, 'view'])->name('sliders.view');
        Route::get('/list', [SliderController::class, 'list'])->name('sliders.list');
        Route::get('/add', [SliderController::class, 'add'])->name('sliders.add');
        Route::post('/store', [SliderController::class, 'store'])->name('sliders.store');
        Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('sliders.edit');
        Route::post('/update/{id}', [SliderController::class, 'update'])->name('sliders.update');
        Route::get('/delete/{id}', [SliderController::class, 'delete'])->name('sliders.delete');
    });

    Route::prefix('abouts')->group(function () {
        Route::get('/view', [AboutController::class, 'view'])->name('abouts.view');
        Route::get('/add', [AboutController::class, 'add'])->name('abouts.add');
        Route::post('/store', [AboutController::class, 'store'])->name('abouts.store');
        Route::get('/edit/{id}', [AboutController::class, 'edit'])->name('abouts.edit');
        Route::post('/update/{id}', [AboutController::class, 'update'])->name('abouts.update');
        Route::post('/delete', [AboutController::class, 'delete'])->name('abouts.delete');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/view', [SettingController::class, 'index'])->name('settings.view');
        Route::get('/notification', [SettingController::class, 'notificationSettings'])->name('settings.notification');
        Route::post('/notification/update', [SettingController::class, 'updateNotificationSettings'])->name('settings.notification.update');
        Route::get('/invoice', [SettingController::class, 'invoiceSettings'])->name('settings.invoice');
        Route::get('/livechat', [SettingController::class, 'livechatSettings'])->name('settings.livechat');
        Route::get('/seo', [SettingController::class, 'seoSettings'])->name('settings.seo');
        Route::put('/seo/update', [SettingController::class, 'updateSeoSettings'])->name('settings.seo.update');
        Route::put('/livechat/update', [SettingController::class, 'updateLivechatSettings'])->name('settings.livechat.update');
        Route::put('/invoice/update', [SettingController::class, 'updateInvoiceSettings'])->name('settings.invoice.update');
        Route::post('/notification/update', [SettingController::class, 'updateNotificationSettings'])->name('settings.notification.update');
        Route::get('/add', [SettingController::class, 'create'])->name('settings.add');
        Route::post('/store', [SettingController::class, 'store'])->name('settings.store');
        Route::get('/edit/{id}', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('/update/{id}', [SettingController::class, 'update'])->name('settings.update');
        Route::post('/delete', [SettingController::class, 'delete'])->name('settings.delete');

        Route::prefix('commission')->group(function () {
            Route::get('/', [CommissionSettingController::class, 'index'])->name('settings.commission.index');
            Route::post('/update', [CommissionSettingController::class, 'update'])->name('settings.commission.update');
        });
    });

    Route::prefix('page')->group(function () {
        Route::resource('pages', PageController::class);
    });

    Route::prefix('contacts')->group(function () {
        Route::get('/view', [ContactController::class, 'view'])->name('contacts.view');
        Route::get('/add', [ContactController::class, 'add'])->name('contacts.add');
        Route::post('/store', [ContactController::class, 'store'])->name('contacts.store');
        Route::get('/edit/{id}', [ContactController::class, 'edit'])->name('contacts.edit');
        Route::post('/update/{id}', [ContactController::class, 'update'])->name('contacts.update');
        Route::post('/delete', [ContactController::class, 'delete'])->name('contacts.delete');

        // Communication
        Route::get('/communicate', [ContactController::class, 'viewCommunicate'])->name('contacts.communicate');
        Route::get('/communicate/list', [ContactController::class, 'communicateList'])->name('contacts.communicate.list');
        Route::get('/communicate/delete/{id}', [
            ContactController::class,
            'deleteCommunicate'
        ])->name('contacts.communicate.delete');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/view', [CategoryController::class, 'view'])->name('categories.view');
        Route::get('/list', [CategoryController::class, 'list'])->name('categories.list');
        Route::get('/add', [categoryController::class, 'add'])->name('categories.add');
        Route::post('/store', [categoryController::class, 'store'])->name('categories.store');
        Route::get('/edit/{id}', [categoryController::class, 'edit'])->name('categories.edit');
        Route::post('/update/{id}', [categoryController::class, 'update'])->name('categories.update');
        Route::get('/delete/{id}', [categoryController::class, 'delete'])->name('categories.delete');
    });

    Route::prefix('subcategories')->group(function () {
        Route::get('/view', [SubcategoryController::class, 'view'])->name('subcategories.view');
        Route::get('/list', [SubcategoryController::class, 'list'])->name('subcategories.list');
        Route::get('/add', [SubcategoryController::class, 'add'])->name('subcategories.add');
        Route::post('/store', [SubcategoryController::class, 'store'])->name('subcategories.store');
        Route::get('/edit/{id}', [SubcategoryController::class, 'edit'])->name('subcategories.edit');
        Route::post('/update/{id}', [SubcategoryController::class, 'update'])->name('subcategories.update');
        Route::get('/delete/{id}', [SubcategoryController::class, 'delete'])->name('subcategories.delete');
    });

    Route::prefix('brands')->group(function () {
        Route::get('/view', [BrandController::class, 'view'])->name('brands.view');
        Route::get('/list', [BrandController::class, 'list'])->name('brands.list');
        Route::get('/add', [BrandController::class, 'add'])->name('brands.add');
        Route::post('/store', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
        Route::post('/update/{id}', [BrandController::class, 'update'])->name('brands.update');
        Route::get('/delete/{id}', [BrandController::class, 'delete'])->name('brands.delete');
    });

    Route::prefix('colors')->group(function () {
        Route::get('/view', [ColorController::class, 'view'])->name('colors.view');
        Route::get('/list', [ColorController::class, 'list'])->name('colors.list');
        Route::get('/add', [ColorController::class, 'add'])->name('colors.add');
        Route::post('/store', [ColorController::class, 'store'])->name('colors.store');
        Route::get('/edit/{id}', [ColorController::class, 'edit'])->name('colors.edit');
        Route::post('/update/{id}', [ColorController::class, 'update'])->name('colors.update');
        Route::get('/delete/{id}', [ColorController::class, 'delete'])->name('colors.delete');
    });

    Route::prefix('sizes')->group(function () {
        Route::get('/view', [SizeController::class, 'view'])->name('sizes.view');
        Route::get('/list', [SizeController::class, 'list'])->name('sizes.list');
        Route::get('/add', [SizeController::class, 'add'])->name('sizes.add');
        Route::post('/store', [SizeController::class, 'store'])->name('sizes.store');
        Route::get('/edit/{id}', [SizeController::class, 'edit'])->name('sizes.edit');
        Route::post('/update/{id}', [SizeController::class, 'update'])->name('sizes.update');
        Route::get('/delete/{id}', [SizeController::class, 'delete'])->name('sizes.delete');
    });
    Route::prefix('color-setting')->group(function () {
        Route::get('/', [ColorSettingController::class, 'index'])->name('color-settings.index');
        Route::post('update', [ColorSettingController::class, 'update'])->name('color-settings.update');
        Route::post('/reset', [ColorSettingController::class, 'reset'])->name('color-settings.reset');
    });

    Route::prefix('areas')->group(function () {
        // Division Codding here.....
        Route::get('/division', [AreaController::class, 'divisionView'])->name('areas.division');
        Route::get('/division/list', [AreaController::class, 'divisionList'])->name('areas.division.list');
        Route::get('division/add', [AreaController::class, 'divisionAdd'])->name('areas.division.add');
        Route::post('division/store', [AreaController::class, 'divisionStore'])->name('areas.division.store');
        Route::get('division/edit/{id}', [AreaController::class, 'divisionEdit'])->name('areas.division.edit');
        Route::post('division/update/{id}', [AreaController::class, 'divisionUpdate'])->name('areas.division.update');
        Route::get('division/delete/{id}', [AreaController::class, 'divisionDelete'])->name('areas.division.delete');

        // Location Codding here...
        Route::get('/location', [AreaController::class, 'locationView'])->name('areas.location');
        Route::get('/location/list', [AreaController::class, 'locationList'])->name('areas.location.list');
        Route::get('location/add', [AreaController::class, 'locationAdd'])->name('areas.location.add');
        Route::post('location/store', [AreaController::class, 'locationStore'])->name('areas.location.store');
        Route::get('location/edit/{id}', [AreaController::class, 'locationEdit'])->name('areas.location.edit');
        Route::post('location/update/{id}', [AreaController::class, 'locationUpdate'])->name('areas.location.update');
        Route::get('location/delete/{id}', [AreaController::class, 'locationDelete'])->name('areas.location.delete');

        // Sub Location Codding here...
        Route::get('/sub_location', [AreaController::class, 'sub_locationView'])->name('areas.sub_location');
        Route::get('/sub_location/list', [AreaController::class, 'sub_locationList'])->name('areas.sub_location.list');
        Route::get('sub_location/add', [AreaController::class, 'sub_locationAdd'])->name('areas.sub_location.add');
        Route::post('sub_location/store', [AreaController::class, 'sub_locationStore'])->name('areas.sub_location.store');
        Route::get('sub_location/edit/{id}', [AreaController::class, 'sub_locationEdit'])->name('areas.sub_location.edit');
        Route::post('sub_location/update/{id}', [
            AreaController::class,
            'sub_locationUpdate'
        ])->name('areas.sub_location.update');
        Route::get('sub_location/delete/{id}', [
            AreaController::class,
            'sub_locationDelete'
        ])->name('areas.sub_location.delete');

        // Area Codding here...
        Route::get('/area', [AreaController::class, 'areaView'])->name('areas.area');
        Route::get('/area/list', [AreaController::class, 'areaList'])->name('areas.area.list');
        Route::get('area/add', [AreaController::class, 'areaAdd'])->name('areas.area.add');
        Route::post('area/store', [AreaController::class, 'areaStore'])->name('areas.area.store');
        Route::get('area/edit/{id}', [AreaController::class, 'areaEdit'])->name('areas.area.edit');
        Route::post('area/update/{id}', [AreaController::class, 'areaUpdate'])->name('areas.area.update');
        Route::get('area/delete/{id}', [AreaController::class, 'areaDelete'])->name('areas.area.delete');
    });

    Route::prefix('reports')->group(function () {
        Route::get('/refer-commission', [AdminReportController::class, 'refer_commissions'])->name('reports.refer_commission');
        Route::get('/vendor-sales', [
            AdminReportController::class,
            'vendor_sales_reports'
        ])->name('reports.vendor_sales_reports');
        Route::get('/reseller-commission', [
            AdminReportController::class,
            'reseller_commission'
        ])->name('reports.reseller_commission');
        Route::get('/dropshipper-history', [
            AdminReportController::class,
            'dropshipper_history'
        ])->name('reports.dropshipper_history');
        Route::get('/admin-commission-for-vendor-product-sales', [
            AdminReportController::class,
            'admin_commission_for_vendor_product_sales'
        ])->name('reports.admin_commission_for_vendor_product_sales');
    });

    Route::prefix('coupons')->group(function () {
        Route::get('/view', [CouponController::class, 'view'])->name('coupons.view');
        Route::get('/list', [CouponController::class, 'list'])->name('coupons.list');
        Route::get('/add', [CouponController::class, 'add'])->name('coupons.add');
        Route::post('/store', [CouponController::class, 'store'])->name('coupons.store');
        Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('coupons.edit');
        Route::post('/update/{id}', [CouponController::class, 'update'])->name('coupons.update');
        Route::get('/delete/{id}', [CouponController::class, 'delete'])->name('coupons.delete');
    });

    Route::prefix('products')->group(function () {
        Route::get('/view', [ProductController::class, 'view'])->name('products.view');
        Route::get('/pending/view', [ProductController::class, 'pending_product_list'])->name('products.pending.view');
        Route::get('/inactive/view', [ProductController::class, 'inactive_product_list'])->name('products.inactive.view');
        Route::get('/status/{id}', [ProductController::class, 'productStatus'])->name('products.status');
        Route::get('/status/inactive/{id}', [ProductController::class, 'productUnStatus'])->name('products.unstatus');
        Route::get('/list', [ProductController::class, 'list'])->name('products.list');
        Route::get('/pending/list', [ProductController::class, 'get_pendinglist'])->name('products.pendinglist');
        Route::get('/inactive/list', [ProductController::class, 'get_inactivelist'])->name('products.inactivelist');
        Route::get('/add', [ProductController::class, 'add'])->name('products.add');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
        
        Route::get('/stockout/view', [ProductController::class, 'stockOutList'])->name('products.stockout.view');
        Route::get('/stockout/list', [ProductController::class, 'getStockOutList'])->name('products.stockout.list');
        Route::get('/lowstock/view', [ProductController::class, 'lowStockList'])->name('products.lowstock.view');
        Route::get('/lowstock/list', [ProductController::class, 'getLowStockList'])->name('products.lowstock.list');
        
        Route::post('/toggle-status/{id}', [ProductController::class, 'toggleStatus'])->name('products.toggle.status');
    });
    });

    Route::prefix('customers')->group(function () {
        Route::get('/view', [CustomerController::class, 'view'])->name('customers.view');
        Route::get('/customer/list', [CustomerController::class, 'customerList'])->name('customers.list');
        Route::get('/draft/view', [CustomerController::class, 'draftView'])->name('customers.draft.view');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::post('/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
        Route::get('/customer/draft/list', [CustomerController::class, 'customerDraftList'])->name('customers.draft.list');
        Route::get('/delete/{id}', [CustomerController::class, 'delete'])->name('customers.delete');
    });

    Route::prefix('vendors')->group(function () {
        Route::get('/view', [VendorController::class, 'view'])->name('vendors.view');
        Route::get('/vendor/list', [VendorController::class, 'vendorList'])->name('vendors.list');
        Route::get('/edit/{id}', [VendorController::class, 'vendorEdit'])->name('vendors.edit');
        Route::get('/status/{id}/{status}', [VendorController::class, 'vendorStatus'])->name('vendors.status');
        Route::get('/payment_status/{id}/{payment_status}', [
            VendorController::class,
            'vendorPaymentStatus_new'
        ])->name('vendors.payment_status');
        Route::post('/update/{id}', [VendorController::class, 'vendorUpdate'])->name('vendors.update');
        Route::get('/draft/view', [VendorController::class, 'draftView'])->name('vendors.draft.view');
        Route::get('vendor/draft/list', [VendorController::class, 'draftList'])->name('vendors.draft.list');
        Route::get('/delete/{id}', [VendorController::class, 'delete'])->name('vendors.delete');
        Route::get('/payment/status/{id}', [VendorController::class, 'VendorPaymentStatus'])->name('vendors.statuschanged');
        Route::get('/profile/verify/{userid}', [
            VendorController::class,
            'VendorProfileVerify'
        ])->name('vendors.profile.verify');
        Route::get('/profile/vendor/delete/{userid}', [
            VendorController::class,
            'VendorProfileDelete'
        ])->name('vendors_profile.delete');
        Route::get('/approved', [VendorController::class, 'approved'])->name('vendors.approved');
        Route::post('/commission', [VendorController::class, 'vendorCommission'])->name('vendors.commission');
    });
    Route::prefix('dropshippers')->group(function () {
        Route::get('/view', [DropshipperController::class, 'view'])->name('dropshippers.view');
        Route::get('/vendor/list', [DropshipperController::class, 'dropshipperList'])->name('dropshippers.list');
        Route::get('/edit/{id}', [DropshipperController::class, 'dropshipperEdit'])->name('dropshippers.edit');
        Route::get('/status/{id}/{status}', [DropshipperController::class, 'dropshipperStatus'])->name('dropshippers.status');
        Route::get('/payment_status/{id}/{payment_status}', [
            DropshipperController::class,
            'dropshipperPaymentStatus_new'
        ])->name('dropshippers.payment_status');
        Route::post('/update/{id}', [DropshipperController::class, 'dropshipperUpdate'])->name('dropshippers.update');
        Route::get('/draft/view', [DropshipperController::class, 'draftView'])->name('dropshippers.draft.view');
        Route::get('vendor/draft/list', [DropshipperController::class, 'draftList'])->name('dropshippers.draft.list');
        Route::get('/delete/{id}', [DropshipperController::class, 'delete'])->name('dropshippers.delete');
        Route::get('/payment/status/{id}', [
            DropshipperController::class,
            'dropshipperPaymentStatus'
        ])->name('dropshippers.statuschanged');
        Route::get('/profile/verify/{userid}', [
            DropshipperController::class,
            'dropshipperProfileVerify'
        ])->name('dropshippers.profile.verify');
        Route::get('/profile/vendor/delete/{userid}', [
            DropshipperController::class,
            'dropshipperProfileDelete'
        ])->name('dropshippers_profile.delete');
        Route::get('/approved', [DropshipperController::class, 'approved'])->name('dropshippers.approved');
        Route::post('/commission', [DropshipperController::class, 'dropshipperCommission'])->name('dropshippers.commission');
    });
    Route::prefix('shopsellers')->group(function () {
        Route::get('/view', [ManageSellerController::class, 'view'])->name('sellers.view');
        Route::post('/refer/amount', [ManageSellerController::class, 'ReferBalace'])->name('sellers.add.balance');
        Route::get('/sellers/profile/{userid}', [
            ManageSellerController::class,
            'SellerProfileVerify'
        ])->name('sellers.profile');
        Route::get('/sellers/profile/delete/{userid}', [
            ManageSellerController::class,
            'SellerProfileDelete'
        ])->name('sellers.profile_delete');
        Route::get('/sellers/list', [ManageSellerController::class, 'sellerList'])->name('sellers.list');
        Route::get('/edit/{id}', [ManageSellerController::class, 'sellerEdit'])->name('sellers.edit');
        Route::post('/update/{id}', [ManageSellerController::class, 'sellerUpdate'])->name('sellers.update');
        Route::get('/draft/view', [ManageSellerController::class, 'draftView'])->name('sellers.draft.view');
        Route::get('sellers/draft/list', [ManageSellerController::class, 'draftList'])->name('sellers.draft.list');
        Route::get('/delete/{id}', [ManageSellerController::class, 'delete'])->name('sellers.delete');
        Route::post('/commission', [ManageSellerController::class, 'sellers_commission'])->name('sellers.commission');
        Route::get('/approved', [ManageSellerController::class, 'approved'])->name('sellers.approved');
        Route::post('/commission', [ManageSellerController::class, 'sellerCommission'])->name('sellers.commission');
    });
    Route::prefix('orders')->group(function () {
        // Route::get('/pending/list', [OrderController::class, 'pendingList'])->name('orders.pending.list');
        Route::get('/delete/{id}', [OrderController::class, 'delete'])->name('orders.delete');
        Route::get('/delivery/list', [OrderController::class, 'deliveryList'])->name('orders.dlist');
        Route::get('/plist', [OrderController::class, 'pList'])->name('orders.plist');
        Route::get('/all/order-list', [OrderController::class, 'AllOrderList'])->name('orders.all.list');
        Route::get('/seller/order-list', [OrderController::class, 'SellerOrderList'])->name('orders.seller.list');
        Route::get('/list', [OrderController::class, 'list'])->name('orders.list');
        Route::get('/print/{id}', [OrderController::class, 'printOrder'])->name('orders.print');
        Route::get('/seller/order/list', [
            OrderController::class,
            'vendorOrSellerOrderlist'
        ])->name('seller.orders.listbyadmin');
        Route::get('/delivered/order', [OrderController::class, 'deliveredList'])->name('orders.deliver.list');
        Route::get('/pending/details/{id}', [OrderController::class, 'pendingDetails'])->name('pending.orders.details');
        Route::get('/details/{id}', [OrderController::class, 'details'])->name('orders.details');
        Route::post('/approve', [OrderController::class, 'approve'])->name('orders.approve');
        Route::post('/status/update', [OrderController::class, 'statusUpdate'])->name('status.update');
        Route::post('/vendor/seller/status/update', [
            OrderController::class,
            'VendorOrSellerstatusUpdate'
        ])->name('vendor.status.update');
        Route::get('/order/commission', [OrderController::class, 'orderCommission'])->name('order.commission');
        Route::get('/order/commission/list', [OrderController::class, 'orderCommissionList'])->name('order.commission.list');
        Route::get('/seller/wise/commission', [OrderController::class, 'sellerWiseCommission'])->name('seller.wise.commission');
        Route::get('/seller/wise/commission/list', [
            OrderController::class,
            'sellerWiseCommissionList'
        ])->name('seller.wise.commission.list');
        Route::post('/add/seller/payment', [OrderController::class, 'addSellerPayment'])->name('add.seller.payment');
        // Pending Orders
        Route::get('/pending/order-list', [OrderController::class, 'PendingOrderList'])->name('orders.pending.list');
        Route::get('/pending/list', [OrderController::class, 'list'])->name('orders.pending.data')->defaults(
            'status',
            'pending'
        );

        // Confirmed Orders
        Route::get('/confirmed/order-list', [OrderController::class, 'ConfirmedOrderList'])->name('orders.confirmed.list');
        Route::get('/confirmed/list', [OrderController::class, 'list'])->name('orders.confirmed.data')->defaults(
            'status',
            'confirmed'
        );

        // Delivered Orders
        Route::get('/delivered/order-list', [OrderController::class, 'DeliveredOrderList'])->name('orders.delivered.list');
        Route::get('/delivered/list', [OrderController::class, 'list'])->name('orders.delivered.data')->defaults(
            'status',
            'delivered'
        );

        // Packaging Orders
        Route::get('/packaging/order-list', [OrderController::class, 'PackagingOrderList'])->name('orders.packaging.list');
        Route::get('/packaging/list', [OrderController::class, 'list'])->name('orders.packaging.data')->defaults(
            'status',
            'packaging'
        );

        // Return Orders
        Route::get('/return/order-list', [OrderController::class, 'ReturnOrderList'])->name('orders.return.list');
        Route::get('/return/list', [OrderController::class, 'list'])->name('orders.return.data')->defaults('status', 'return');

        // Canceled Orders
        Route::get('/canceled/order-list', [OrderController::class, 'CanceledOrderList'])->name('orders.canceled.list');
        Route::get('/canceled/list', [OrderController::class, 'list'])->name('orders.canceled.data')->defaults(
            'status',
            'canceled'
        );
    });
    Route::prefix('wallets')->group(function () {
        Route::get('/view', [WalletController::class, 'walletList'])->name('wallets.view');
        Route::get('/received', [WalletController::class, 'walletReceivedList'])->name('wallets.received');
        Route::post('/wallet/submit', [WalletController::class, 'SubmitWalletData'])->name('wallets.money');
        Route::get('/edit/{id}', [WalletController::class, 'walletEdit'])->name('wallets.edit');
        Route::post('/update/{id}', [WalletController::class, 'walletUpdate'])->name('wallets.update');
        Route::get('/delete/{id}', [WalletController::class, 'delete'])->name('wallets.delete');
        Route::get('/approved', [WalletController::class, 'approved'])->name('wallets.approved');
        Route::get('varified/account', [WalletController::class, 'varifiedAccount'])->name('varified.account');
    });



    // WhatsApp Test
    Route::get('/whatsapp/test', function () {
        $service = app(\App\Services\WhatsAppService::class);
        $adminNum = config('services.whatsapp.admin_number');
        $result = $service->sendText(
            $adminNum,
            "✅ U Super Shop\n\nWhatsApp notification সফলভাবে কাজ করছে!\n\n⏰ " . now()->setTimezone('Asia/Dhaka')->format('d M Y, h:i A')
        );
        return $result
            ? redirect()->route('home')->with('success', '✅ WhatsApp test message sent to ' . $adminNum)
            : redirect()->route('home')->with('error', '❌ WhatsApp failed — .env এ WHATSAPP_TOKEN ও WHATSAPP_PHONE_NUMBER_ID সঠিকভাবে দিন');
    })->name('whatsapp.test');


    // ── Recycle Bin ───────────────────────────────────────────────────
    Route::prefix('recycle-bin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\RecycleBinController::class, 'index'])->name('recycle.bin');
        Route::patch('/restore/{type}/{id}', [\App\Http\Controllers\Backend\RecycleBinController::class, 'restore'])->name('recycle.restore');
        Route::patch('/restore-all/{type}', [\App\Http\Controllers\Backend\RecycleBinController::class, 'restoreAll'])->name('recycle.restore-all');
        Route::delete('/force-delete/{type}/{id}', [\App\Http\Controllers\Backend\RecycleBinController::class, 'forceDelete'])->name('recycle.force-delete');
        Route::delete('/empty', [\App\Http\Controllers\Backend\RecycleBinController::class, 'emptyBin'])->name('recycle.empty');
    });

    // ── Blocked Accounts ──────────────────────────────────────────────
    Route::get('/blocked-accounts', [\App\Http\Controllers\Backend\ManageSellerController::class, 'blockedAccounts'])->name('sellers.blocked');
    Route::patch('/unblock-login/{id}', [\App\Http\Controllers\Backend\ManageSellerController::class, 'unblockLogin'])->name('sellers.unblock');

    // ── Courier API Settings ─────────────────────────────────────────
    Route::prefix('couriers')->group(function () {
        Route::get('/settings', [\App\Http\Controllers\Backend\CourierController::class, 'settings'])->name('couriers.settings');
        Route::put('/update/{id}', [\App\Http\Controllers\Backend\CourierController::class, 'update'])->name('couriers.update');
        Route::post('/test', [\App\Http\Controllers\Backend\CourierController::class, 'testConnection'])->name('couriers.test');
    });

    // ── Withdrawal Payment Methods ──────────────────────────────────
    Route::prefix('withdrawal-methods')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\WithdrawalMethodController::class, 'index'])->name('withdrawal.methods.index');
        Route::get('/create', [\App\Http\Controllers\Backend\WithdrawalMethodController::class, 'create'])->name('withdrawal.methods.create');
        Route::post('/store', [\App\Http\Controllers\Backend\WithdrawalMethodController::class, 'store'])->name('withdrawal.methods.store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\WithdrawalMethodController::class, 'edit'])->name('withdrawal.methods.edit');
        Route::put('/update/{id}', [\App\Http\Controllers\Backend\WithdrawalMethodController::class, 'update'])->name('withdrawal.methods.update');
        Route::patch('/toggle/{id}', [\App\Http\Controllers\Backend\WithdrawalMethodController::class, 'toggleActive'])->name('withdrawal.methods.toggle');
        Route::delete('/destroy/{id}', [\App\Http\Controllers\Backend\WithdrawalMethodController::class, 'destroy'])->name('withdrawal.methods.destroy');
    });

    // ── Staff Management (Main Admin Only) ─────────────────────────────
    Route::prefix('staff')->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\StaffController::class, 'index'])->name('staff.index');
        Route::get('/create', [\App\Http\Controllers\Backend\StaffController::class, 'create'])->name('staff.create');
        Route::post('/store', [\App\Http\Controllers\Backend\StaffController::class, 'store'])->name('staff.store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/update/{id}', [\App\Http\Controllers\Backend\StaffController::class, 'update'])->name('staff.update');
        Route::patch('/toggle/{id}', [\App\Http\Controllers\Backend\StaffController::class, 'toggleActive'])->name('staff.toggle');
        Route::delete('/destroy/{id}', [\App\Http\Controllers\Backend\StaffController::class, 'destroy'])->name('staff.destroy');
    });