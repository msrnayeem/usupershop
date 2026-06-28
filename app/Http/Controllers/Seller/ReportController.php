<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\CommissionLedger;
use App\Models\User;
use App\Utilities\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function refer_list(){
        $pageTitle = 'Refer List';
        $user = Auth::user();
        $data = User::where('reseller_id', $user->id)->where('status', 1)->get();

        return view('backend.seller.reports.refer_list', compact('data', 'pageTitle'));
    }
    public function refer_commission_list(){
        $pageTitle = 'Refer Commissions';
        $user = Auth::user();
        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])->where('tnx_type', Constant::TRANSACTION_TYPE['refer_commission'])->where('user_id', $user->id)->get();

        return view('backend.seller.reports.refer_commissions', compact('data', 'pageTitle'));
    }
    public function refer_sales_list(){
        $pageTitle = 'Product Sales';
        $user = Auth::user();
        $data = CommissionLedger::with(['order', 'order.users'])->where('reseller_id', $user->id)->where('reference', 'LIKE', 'vendor_comm%')->latest()->get();

        return view('backend.seller.reports.vendor_sales_reports', compact('data', 'pageTitle'));
    }
    public function reseller_commission_reports(){
        $pageTitle = 'Reseller Sales Commissions';
        $user = Auth::user();
        $data = CommissionLedger::with(['order', 'order.users'])->where('reseller_id', $user->id)->where('reference', 'LIKE', 'reseller_comm%')->latest()->get();

        return view('backend.seller.reports.reseller_commission_reports', compact('data', 'pageTitle'));
    }

    public function export_sales_pdf() {
        $user = Auth::user();
        $data = CommissionLedger::with(['order', 'order.users'])->where('reseller_id', $user->id)->where('reference', 'LIKE', 'vendor_comm%')->latest()->get();
        $pageTitle = 'Vendor Product Sales Report';
        
        $pdf = Pdf::loadView('backend.seller.reports.export_pdf', compact('data', 'pageTitle', 'user'));
        return $pdf->download('vendor_sales_report.pdf');
    }

    public function export_sales_excel() {
        $user = Auth::user();
        $data = CommissionLedger::with(['order', 'order.users'])->where('reseller_id', $user->id)->where('reference', 'LIKE', 'vendor_comm%')->latest()->get();
        
        $response = new StreamedResponse(function() use($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['SL', 'Date', 'Order No', 'Customer', 'Amount']);

            foreach ($data as $i => $value) {
                fputcsv($handle, [
                    ++$i,
                    date('d-M-Y', strtotime($value->entry_date)),
                    '#' . ($value->order->order_no ?? 'N/A'),
                    $value->order->users->name ?? 'Unknown',
                    number_format($value->credit_balance, 2)
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="vendor_sales_report.csv"');
        return $response;
    }

    public function export_commission_pdf() {
        $user = Auth::user();
        $data = CommissionLedger::with(['order', 'order.users'])->where('reseller_id', $user->id)->where('reference', 'LIKE', 'reseller_comm%')->latest()->get();
        $pageTitle = 'Reseller Sales Commission Report';
        
        $pdf = Pdf::loadView('backend.seller.reports.export_pdf', compact('data', 'pageTitle', 'user'));
        return $pdf->download('reseller_commission_report.pdf');
    }

    public function export_commission_excel() {
        $user = Auth::user();
        $data = CommissionLedger::with(['order', 'order.users'])->where('reseller_id', $user->id)->where('reference', 'LIKE', 'reseller_comm%')->latest()->get();
        
        $response = new StreamedResponse(function() use($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['SL', 'Date', 'Order No', 'Customer', 'Amount']);

            foreach ($data as $i => $value) {
                fputcsv($handle, [
                    ++$i,
                    date('d-M-Y', strtotime($value->entry_date)),
                    '#' . ($value->order->order_no ?? 'N/A'),
                    $value->order->users->name ?? 'Unknown',
                    number_format($value->credit_balance, 2)
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="reseller_commission_report.csv"');
        return $response;
    }

    public function export_refer_pdf() {
        $user = Auth::user();
        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])->where('tnx_type', Constant::TRANSACTION_TYPE['refer_commission'])->where('user_id', $user->id)->get();
        $pageTitle = 'Refer Commissions Report';
        
        $pdf = Pdf::loadView('backend.seller.reports.export_refer_pdf', compact('data', 'pageTitle', 'user'));
        return $pdf->download('refer_commission_report.pdf');
    }

    public function export_refer_excel() {
        $user = Auth::user();
        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])->where('tnx_type', Constant::TRANSACTION_TYPE['refer_commission'])->where('user_id', $user->id)->get();
        
        $response = new StreamedResponse(function() use($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['SL', 'From User', 'Description', 'Amount']);

            foreach ($data as $i => $value) {
                fputcsv($handle, [
                    ++$i,
                    $value->from_user->name ?? 'Unknown',
                    $value->note,
                    number_format($value->credit, 2)
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="refer_commission_report.csv"');
        return $response;
    }
}
