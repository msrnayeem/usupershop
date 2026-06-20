<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\SellerOrderController;
use App\Http\Controllers\Backend\SellerProductController;

use App\Http\Controllers\Backend\SellerDashboardController;

use App\Http\Controllers\Seller\ReportController;



//Seller Dashboard
Route::group(['middleware' => ['auth', 'seller']], function () {

    Route::get('/seller-dashboard', [SellerDashboardController::class, 'sellerDashboard'])->name('seller.dashboard');
    Route::get('/get-seller-subscription-fee', [SellerDashboardController::class, 'sellerSubscriptionFee'])->name('seller.subscriptionfee');

    Route::prefix('sellers')->group(function () {
        Route::get('/seller-view-profile', [SellerDashboardController::class, 'sellerViewProfile'])->name('sellers.view.profile');
        Route::get('/seller-edit-profile', [SellerDashboardController::class, 'sellerEditProfile'])->name('sellers.edit.profile');
        Route::post('/seller-store-profile', [SellerDashboardController::class, 'sellerUpdateProfile'])->name('sellers.update.profile');
        Route::get('/seller-password/view', [SellerDashboardController::class, 'sellerPasswordView'])->name('sellers.password.view');
        Route::post('/seller-password/update', [SellerDashboardController::class, 'sellerPasswordUpdate'])->name('sellers.password.update');
        Route::post('/seller-process-payment', [SellerDashboardController::class, 'sellerProcessPayment'])->name('seller.processPayment');
        Route::post('/verify/seller/profile', [SellerDashboardController::class, 'sellerVerifyProfile'])->name('nid_profile.update');
        Route::post('/wallets/balance/', [SellerDashboardController::class, 'SaveWallet'])->name('wallet.save');

        //Add my shop
        Route::get('/shopkeeper-product', [SellerProductController::class, 'shopkeeper_product'])->name('sellers.shopkeeper_product');
        Route::get('/shopkeeper-product/search', [SellerProductController::class, 'SearchProducts'])->name('sellers.product_search');
        Route::get('/add-to-my-shop/{product_id}', [SellerProductController::class, 'add_to_my_shop']);
        Route::get('/manage_wallets', [SellerProductController::class, 'MyWallets'])->name('manage.wallets');
        Route::get('/manage-payment-method', [App\Http\Controllers\Backend\PaymentSettingController::class, 'index'])->name('manage.wallets.payment');
        Route::post('/manage-payment-method/store', [App\Http\Controllers\Backend\PaymentSettingController::class, 'store'])->name('manage.wallets.payment.store');
        Route::get('/manage_wallets/verify', [SellerProductController::class, 'MyWalletsVerified'])->name('manage.wallets.verified');
        Route::get('/transaction_history', [SellerProductController::class, 'TransactionHistory'])->name('transaction.history');
        Route::get('/my-product-list', [SellerProductController::class, 'myproductlist'])->name('sellers.product.list');
        Route::get('/my-product-delete/{id}', [SellerProductController::class, 'myProductDelete'])->name('sellers.products.delete');
        Route::get('/seller-product', [SellerProductController::class, 'seller_product'])->name('sellers.seller_product');
        Route::get('/vendor-product/view', [SellerProductController::class, 'vendorProductView'])->name('vendor.productview');
        Route::get('/vendor-product/list', [SellerProductController::class, 'vendorProductList'])->name('vendor.productlist');
        Route::get('/vendor-product/create', [SellerProductController::class, 'addVendorProduct'])->name('vendor.addproduct');
        Route::post('/vendor-product/save', [SellerProductController::class, 'storeVendorProduct'])->name('vendor.store.product');
        Route::get('/vendor-product/edit/{id}', [SellerProductController::class, 'editVendorProduct'])->name('vendor.editproduct');
        Route::post('/vendor-product/update/{id}', [SellerProductController::class, 'VendorProductUpdate'])->name('vendor.updateproduct');
        Route::get('/vendor-product/delete/{id}', [SellerProductController::class, 'deleteVendorProduct'])->name('vendor.deleteproduct');
    });

    Route::prefix('seller-orders')->group(function () {
        Route::get('/pending/list', [SellerOrderController::class, 'sellerPending'])->name('seller.orders.pending.list');
        Route::get('/confirmed/list', [SellerOrderController::class, 'sellerConfirmed'])->name('seller.orders.confirmed.list');
        Route::get('/packaging/list', [SellerOrderController::class, 'sellerPackaging'])->name('seller.orders.packaging.list');
        Route::get('/shipment/list', [SellerOrderController::class, 'sellerShipment'])->name('seller.orders.shipment.list');
        Route::get('/delivered/list', [SellerOrderController::class, 'sellerDelivered'])->name('seller.orders.delivered.list');
        Route::get('/cancel/list', [SellerOrderController::class, 'sellerCancel'])->name('seller.orders.cancel.list');
        Route::get('/return/list', [SellerOrderController::class, 'sellerReturn'])->name('seller.orders.return.list');

        Route::get('/pending/print/{id}', [SellerOrderController::class, 'sellerPendingPrintOrder'])->name('seller.orders_print');
        Route::get('/plist', [SellerOrderController::class, 'sellerPendingList'])->name('seller.orders.plist');
        Route::get('/delivered/list', [SellerOrderController::class, 'sellerDelivered'])->name('seller.orders.delivered.list');
        Route::get('/dlist', [SellerOrderController::class, 'sellerDeliveredList'])->name('seller.orders.dlist');
        Route::get('/list', [SellerOrderController::class, 'sellerApprovedList'])->name('seller.orders.list');
        Route::get('/pending/details/{id}', [SellerOrderController::class, 'sellerPendingDetails'])->name('seller.pending.orders.details');
        Route::get('/delivered/details/{id}', [SellerOrderController::class, 'sellerDeliveredDetails'])->name('seller.delivered.orders.details');
        Route::get('/details/{id}', [SellerOrderController::class, 'sellerDetails'])->name('seller.orders.details');
        Route::get('/clist', [SellerOrderController::class, 'sellerCancelList'])->name('seller.orders.clist');
        Route::get('/cancel/details/{id}', [SellerOrderController::class, 'sellerCancelDetails'])->name('seller.cancel.orders.details');
        Route::get('/rlist', [SellerOrderController::class, 'sellerReturnList'])->name('seller.orders.rlist');
        Route::get('/return/details/{id}', [SellerOrderController::class, 'sellerReturnDetails'])->name('seller.return.orders.details');
        Route::get('/track/{id}', [SellerOrderController::class, 'trackOrder'])->name('seller.orders.track');
    });

    Route::prefix('seller-reports')->group(function () {
        Route::get('/refer/commission', [ReportController::class, 'refer_commission_list'])->name('seller.reports.refer');
        Route::get('/refer/commission/export/pdf', [ReportController::class, 'export_refer_pdf'])->name('seller.reports.refer.pdf');
        Route::get('/refer/commission/export/excel', [ReportController::class, 'export_refer_excel'])->name('seller.reports.refer.excel');
        Route::get('/sales', [ReportController::class, 'refer_sales_list'])->name('seller.reports.sales');
        Route::get('/sales/export/pdf', [ReportController::class, 'export_sales_pdf'])->name('seller.reports.sales.pdf');
        Route::get('/sales/export/excel', [ReportController::class, 'export_sales_excel'])->name('seller.reports.sales.excel');
        
        Route::get('/reseller-commission', [ReportController::class, 'reseller_commission_reports'])->name('seller.reports.reseller_commission_reports');
        Route::get('/reseller-commission/export/pdf', [ReportController::class, 'export_commission_pdf'])->name('seller.reports.reseller_commission.pdf');
        Route::get('/reseller-commission/export/excel', [ReportController::class, 'export_commission_excel'])->name('seller.reports.reseller_commission.excel');
    });

    Route::prefix('seller-refer')->group(function () {
        Route::get('/list', [ReportController::class, 'refer_list'])->name('sellers.refer.list');
    });
});
