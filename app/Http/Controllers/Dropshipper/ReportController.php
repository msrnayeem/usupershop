<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Utilities\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Refer List - Users referred by the dropshipper
     */
    public function refer_list()
    {
        $pageTitle = 'Refer List';
        $user = Auth::user();

        $data = User::where('reseller_id', $user->id)
            ->where('status', 1)
            ->get();

        return view('backend.dropshipper.reports.refer_list', compact('data', 'pageTitle'));
    }

    /**
     * Refer Commission List - Commissions from referrals
     */
    public function refer_commission_list()
    {
        $pageTitle = 'Refer Commissions';
        $user = Auth::user();

        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['refer_commission'])
            ->where('user_id', $user->id)
            ->get();

        return view('backend.dropshipper.reports.refer_commissions', compact('data', 'pageTitle'));
    }

    /**
     * Sales List - Product sales made by dropshipper
     */
    public function refer_sales_list()
    {
        $pageTitle = 'Product Sales';
        $user = Auth::user();

        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['product_seles'])
            ->where('user_id', $user->id)
            ->get();

        return view('backend.dropshipper.reports.dropshipper_sales_reports', compact('data', 'pageTitle'));
    }

    /**
     * Dropshipper Commission Reports - Commissions from sales
     */
    public function reseller_commission_reports()
    {
        $pageTitle = 'Dropshipper Sales Commissions';
        $user = Auth::user();

        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['reseller_seles_commission'])
            ->where('user_id', $user->id)
            ->get();

        return view('backend.dropshipper.reports.reseller_commission_reports', compact('data', 'pageTitle'));
    }

    public function export_sales_pdf() {
        $user = Auth::user();
        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['product_seles'])
            ->where('user_id', $user->id)
            ->get();
        $pageTitle = 'Dropshipper Product Sales Report';
        
        $pdf = Pdf::loadView('backend.dropshipper.reports.export_pdf', compact('data', 'pageTitle', 'user'));
        return $pdf->download('dropshipper_sales_report.pdf');
    }

    public function export_sales_excel() {
        $user = Auth::user();
        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['product_seles'])
            ->where('user_id', $user->id)
            ->get();
        
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
        $response->headers->set('Content-Disposition', 'attachment; filename="dropshipper_sales_report.csv"');
        return $response;
    }

    public function export_commission_pdf() {
        $user = Auth::user();
        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['reseller_seles_commission'])
            ->where('user_id', $user->id)
            ->get();
        $pageTitle = 'Dropshipper Sales Commission Report';
        
        $pdf = Pdf::loadView('backend.dropshipper.reports.export_pdf', compact('data', 'pageTitle', 'user'));
        return $pdf->download('dropshipper_commission_report.pdf');
    }

    public function export_commission_excel() {
        $user = Auth::user();
        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['reseller_seles_commission'])
            ->where('user_id', $user->id)
            ->get();
        
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
        $response->headers->set('Content-Disposition', 'attachment; filename="dropshipper_commission_report.csv"');
        return $response;
    }

    public function export_refer_pdf() {
        $user = Auth::user();
        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['refer_commission'])
            ->where('user_id', $user->id)
            ->get();
        $pageTitle = 'Dropshipper Refer Commissions Report';
        
        $pdf = Pdf::loadView('backend.dropshipper.reports.export_pdf', compact('data', 'pageTitle', 'user'));
        return $pdf->download('dropshipper_refer_commission_report.pdf');
    }

    public function export_refer_excel() {
        $user = Auth::user();
        $data = Transaction::with('from_user')->where('wallet_type', Constant::WALLET_TYPE['balance_wallet'])
            ->where('tnx_type', Constant::TRANSACTION_TYPE['refer_commission'])
            ->where('user_id', $user->id)
            ->get();
        
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
        $response->headers->set('Content-Disposition', 'attachment; filename="dropshipper_refer_commission_report.csv"');
        return $response;
    }
}
