<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\DropshipperProfit;
use App\Utilities\Constant;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function dropshipper_history(){
        $pageTitle = 'Dropshippers History';
        $history = Transaction::with(['user', 'from_user'])
            ->whereHas('user', function($q){
                $q->where('usertype', 'dropshipper');
            })
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.reports.dropshipper-history', compact('history', 'pageTitle'));
    }

    public function refer_commissions(){
        $pageTitle = 'Refer Commission';
        $commissions = Transaction::with(['user', 'from_user'])
            ->where('status', Constant::STATUS['approved'])
            ->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['refer_commission'])
            ->get();
        return view('backend.reports.refer-commissions', compact('commissions', 'pageTitle'));
    }

    public function vendor_sales_reports(){
        $pageTitle = 'Vendor Sales';
        $sales = Transaction::with(['user', 'from_user'])
            ->where('status', Constant::STATUS['approved'])
            ->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['product_seles'])
            ->get();
        return view('backend.reports.vendor-sales', compact('sales', 'pageTitle'));
    }

    public function reseller_commission(){
        $pageTitle = 'Reseller Commissions';
        $commissions = Transaction::with(['user', 'from_user'])
            ->where('status', Constant::STATUS['approved'])
            ->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['reseller_seles_commission'])
            ->get();
        return view('backend.reports.reseller-commissions', compact('commissions', 'pageTitle'));
    }

    public function admin_commission_for_vendor_product_sales(){
        $pageTitle = 'Admin Commission for Vendor Product Sales';
        $commissions = Transaction::with(['user', 'from_user'])
            ->where('status', Constant::STATUS['approved'])
            ->where('wallet_type', Constant::WALLET_TYPE['admin_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['admin_sales_commission_amount'])
            ->get();
        return view('backend.reports.admin_commission_for_vendor_product_sales', compact('commissions', 'pageTitle'));
    }
}
