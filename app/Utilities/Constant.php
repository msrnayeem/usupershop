<?php
namespace App\utilities;
class Constant {

    const EPS_INFO = [
        'successUrl' => '/api/callback/eps/success',
        'failUrl' => '/api/callback/eps/fail',
        'cancelUrl' => '/api/callback/eps/cancel',
        'trx_charge' => '1.75',
    ];
    const EPS_TRX_TYPE = [
        'web' => 1,
        'android' => 2,
        'ios' => 3,
    ];

    const COMMISSION = [
        'seller_comission' => 10,
        'vendor_comission' => 10,
        'admin_commission' => 20
    ];

    const WALLET_TYPE = [
        'none' => 0,
        'balance_wallet' => 1,
        'admin_wallet' => 2,
    ];

    const TRANSACTION_TYPE = [
        'none' => 0,
        'add_fund' => 1,
        'withdraw' => 2,
        'refer_commission' => 3,
        'product_seles' => 4,
        'reseller_seles_commission' => 5,
        'admin_sales_commission_amount' => 6,
    ];

    const WITHDRAW_STATUS = [
        'pending' => 1,
        'processing' => 2,
        'confirmed' => 3,
        'approved' => 4,
        'rejected' => 5,
    ];

    const STATUS = [
        'approved' => 1,
        'pending' => 2,
        'rejected' => 3,
        'cancel' => 4
    ];
    const IN_STATUS = [
        'active' => 1,
        'deactive' => 0,
    ];

}