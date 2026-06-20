<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DropshipperOrderController;
use App\Http\Controllers\Backend\DropshipperProductController;
use App\Http\Controllers\Backend\DropshipperDashboardController;
use App\Http\Controllers\Dropshipper\ReportController;


// Dropshipper Dashboard Routes
Route::group(['middleware' => ['auth', 'dropshipper']], function () {

    // Dashboard
    Route::get('/dropshipper-dashboard', [DropshipperDashboardController::class, 'dropshipperDashboard'])
        ->name('dropshipper.dashboard');
    Route::get('/get_subscription_fee', [DropshipperDashboardController::class, 'dropshipperSubscriptionFee'])
        ->name('dropshipper.subscriptionfee');

    // Profile Management
    Route::prefix('dropshippers')->group(function () {
        Route::get('/view-profile', [DropshipperDashboardController::class, 'dropshipperViewProfile'])
            ->name('dropshipper.view.profile');
        Route::get('/edit-profile', [DropshipperDashboardController::class, 'dropshipperEditProfile'])
            ->name('dropshipper.edit.profile');
        Route::post('/store-profile', [DropshipperDashboardController::class, 'dropshipperUpdateProfile'])
            ->name('dropshipper.update.profile');

        Route::get('/password/view', [DropshipperDashboardController::class, 'dropshipperPasswordView'])
            ->name('dropshipper.password.view');
        Route::post('/password/update', [DropshipperDashboardController::class, 'dropshipperPasswordUpdate'])
            ->name('dropshipper.password.update');

        // Payment and Wallet
        Route::post('/process-payment', [DropshipperDashboardController::class, 'dropshipperProcessPayment'])
            ->name('dropshipper.processPayment');
        Route::post('/verify/profile', [DropshipperDashboardController::class, 'dropshipperVerifyProfile'])
            ->name('dropshipper.profile.verify');
        Route::post('/wallets/balance', [DropshipperDashboardController::class, 'SaveWallet'])
            ->name('dropshipper.wallet.save');
    });

    // Product Management
    Route::prefix('dropshippers')->group(function () {




        // Add My Shop
        Route::get('/shopkeeper-product', [DropshipperProductController::class, 'shopkeeper_product'])
            ->name('dropshipper.shopkeeper_product');

        Route::get('/shopkeeper-product/search', [DropshipperProductController::class, 'SearchProducts'])
            ->name('dropshipper.product_search');

        Route::get('/add-to-my-shop/{product_id}', [DropshipperProductController::class, 'add_to_my_shop'])
            ->name('dropshipper.add_to_my_shop');

        // Wallet Management
        Route::get('/manage_wallets', [DropshipperProductController::class, 'MyWallets'])
            ->name('dropshipper.manage.wallets');

        Route::get('/manage-payment-method', [App\Http\Controllers\Backend\PaymentSettingController::class, 'index'])
            ->name('dropshipper.manage.wallets.payment');

        Route::post('/manage-payment-method/store', [App\Http\Controllers\Backend\PaymentSettingController::class, 'store'])
            ->name('dropshipper.manage.wallets.payment.store');

        Route::get('/manage_wallets/verify', [DropshipperProductController::class, 'MyWalletsVerified'])
            ->name('dropshipper.manage.wallets.verified');

        // Transactions
        Route::get('/transaction_history', [DropshipperProductController::class, 'TransactionHistory'])
            ->name('dropshipper.transaction.history');

        // My Products
        Route::get('/my-product-list', [DropshipperProductController::class, 'myproductlist'])
            ->name('dropshipper.product.list');

        Route::get('/dropshipper-product/view/{id}', [DropshipperProductController::class, 'productView'])
            ->name('dropshipper.product.view');

        Route::get('/my-product-delete/{id}', [DropshipperProductController::class, 'myProductDelete'])
            ->name('dropshipper.product.delete');

        // Vendor Products
        Route::get('/vendor-product', [DropshipperProductController::class, 'vendorProduct'])
            ->name('dropshipper.vendor.product');

        Route::get('/vendor-product/view', [DropshipperProductController::class, 'vendorProductView'])
            ->name('dropshipper.vendor.product.view');

        Route::get('/vendor-product/list', [DropshipperProductController::class, 'vendorProductList'])
            ->name('dropshipper.vendor.product.list');

        Route::get('/vendor-product/create', [DropshipperProductController::class, 'addVendorProduct'])
            ->name('dropshipper.vendor.product.create');

        Route::post('/vendor-product/save', [DropshipperProductController::class, 'storeVendorProduct'])
            ->name('dropshipper.vendor.product.store');

        Route::get('/vendor-product/edit/{id}', [DropshipperProductController::class, 'editVendorProduct'])
            ->name('dropshipper.vendor.product.edit');

        Route::post('/vendor-product/update/{id}', [DropshipperProductController::class, 'VendorProductUpdate'])
            ->name('dropshipper.vendor.product.update');

        Route::get('/vendor-product/delete/{id}', [DropshipperProductController::class, 'deleteVendorProduct'])
            ->name('dropshipper.vendor.product.delete');






        // Wallet and Payment Settings
        Route::get('/manage-wallets', [DropshipperProductController::class, 'MyWallets'])
            ->name('dropshipper.wallet.index');
        Route::get('/manage-wallets/verify', [DropshipperProductController::class, 'MyWalletsVerified'])
            ->name('dropshipper.wallet.verified');
        Route::get('/transaction-history', [DropshipperProductController::class, 'TransactionHistory'])
            ->name('dropshipper.transaction.history');

        Route::get('/manage-payment-method', [App\Http\Controllers\Backend\PaymentSettingController::class, 'index'])
            ->name('dropshipper.wallet.payment');
        Route::post('/manage-payment-method/store', [App\Http\Controllers\Backend\PaymentSettingController::class, 'store'])
            ->name('dropshipper.wallets.payment.store');
    });

    // Orders
    Route::prefix('dropshipper-orders')->group(function () {
        Route::get('/pending/list', [DropshipperOrderController::class, 'dropshipperPendingList'])
            ->name('dropshipper.orders.pending.list');
        Route::get('/confirmed/list', [DropshipperOrderController::class, 'dropshipperConfirmedList'])
            ->name('dropshipper.orders.confirmed.list');
        Route::get('/packaging/list', [DropshipperOrderController::class, 'dropshipperPackagingList'])
            ->name('dropshipper.orders.packaging.list');
        Route::get('/shipment/list', [DropshipperOrderController::class, 'dropshipperShipmentList'])
            ->name('dropshipper.orders.shipment.list');
        Route::get('/cancel/list', [DropshipperOrderController::class, 'dropshipperCancelList'])
            ->name('dropshipper.orders.cancel.list');
        Route::get('/return/list', [DropshipperOrderController::class, 'dropshipperReturnList'])
            ->name('dropshipper.orders.return.list');
        Route::get('/pending/print/{id}', [DropshipperOrderController::class, 'pendingPrintOrder'])
            ->name('dropshipper.orders.print');
        Route::get('/delivered/list', [DropshipperOrderController::class, 'dropshipperDeliveredList'])
            ->name('dropshipper.orders.delivered.list');
        Route::get('/pending/details/{id}', [DropshipperOrderController::class, 'pendingDetails'])
            ->name('dropshipper.orders.pending.details');
        Route::get('/delivered/details/{id}', [DropshipperOrderController::class, 'deliveredDetails'])
            ->name('dropshipper.orders.delivered.details');
        Route::get('/details/{id}', [DropshipperOrderController::class, 'details'])
            ->name('dropshipper.orders.details');
        Route::get('/track/{id}', [DropshipperOrderController::class, 'trackOrder'])
            ->name('dropshipper.orders.track');
        Route::get('/create', [DropshipperOrderController::class, 'orderCreate'])
            ->name('dropshipper.orders.create');

        Route::get('add-to-cart/{product}', [DropshipperOrderController::class, 'addToCart'])
            ->name('dropshipper.add.to.cart');

    });

    // Reports
    Route::prefix('dropshipper-reports')->group(function () {
        Route::get('/refer/commission', [ReportController::class, 'refer_commission_list'])
            ->name('dropshipper.reports.refer');
        Route::get('/refer/commission/export/pdf', [ReportController::class, 'export_refer_pdf'])
            ->name('dropshipper.reports.refer.pdf');
        Route::get('/refer/commission/export/excel', [ReportController::class, 'export_refer_excel'])
            ->name('dropshipper.reports.refer.excel');

        Route::get('/sales', [ReportController::class, 'refer_sales_list'])
            ->name('dropshipper.reports.sales');
        Route::get('/sales/export/pdf', [ReportController::class, 'export_sales_pdf'])
            ->name('dropshipper.reports.sales.pdf');
        Route::get('/sales/export/excel', [ReportController::class, 'export_sales_excel'])
            ->name('dropshipper.reports.sales.excel');

        Route::get('/reseller-commission', [ReportController::class, 'reseller_commission_reports'])
            ->name('dropshipper.reports.commission');
        Route::get('/reseller-commission/export/pdf', [ReportController::class, 'export_commission_pdf'])
            ->name('dropshipper.reports.commission.pdf');
        Route::get('/reseller-commission/export/excel', [ReportController::class, 'export_commission_excel'])
            ->name('dropshipper.reports.commission.excel');
    });

    // Refer System
    Route::prefix('dropshipper-refer')->group(function () {
        Route::get('/list', [ReportController::class, 'refer_list'])
            ->name('dropshipper.refer.list');
    });




});
