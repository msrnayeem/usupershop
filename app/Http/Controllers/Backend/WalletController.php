<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\SendSmsTrait;
class WalletController extends Controller
{
    use SendSmsTrait;

    public function walletList()
    {
        $data['wallets'] = Wallet::select('wallets.id', 'wallets.user_id', 'wallets.mobile_no', 'wallets.payment_type', 'wallets.transaction_status', 'profile_verifies.nid_no', 'users.name', 'users.balance', 'profile_verifies.front_image')->join('users', 'wallets.user_id', '=', 'users.id')->leftJoin('profile_verifies', 'profile_verifies.user_id', '=', 'users.id')->where('transaction_status', 'waiting')->get();
        return view('backend.wallets.view-wallets', $data);
    }
    public function walletReceivedList()
    {
        $data['wallets'] = Wallet::select('wallets.id', 'wallets.user_id', 'wallets.mobile_no', 
        'wallets.payment_type', 'wallets.transaction_status', 'profile_verifies.nid_no',
         'users.name', 'wallets.transaction_balance','wallets.transaction_date')->join('users', 'wallets.user_id', '=', 'users.id')
         ->leftJoin('profile_verifies', 'profile_verifies.user_id', '=', 'users.id')
         ->where('transaction_status', 'received')->get();
        return view('backend.wallets.history-wallets', $data);
    }
    public function SubmitWalletData(Request $request)
    {
        $request->validate(
            [
                'transaction_id' => ['required', 'unique:wallets,transaction_id'],
                'user_id' => ['required', 'exists:users,id'],
                'balance' => ['required', 'numeric', 'min:0.01'],
            ],
            [
                'transaction_id.unique' => 'This transaction ID already exists in the wallet.',
            ]
        );

        $user = User::find($request->user_id);

        $balance = (float) $request->balance;

        if ($user->balance >= $balance) {
            $user->balance -= $balance;
            $user->save();
            $wallet = Wallet::where('user_id', $user->id)->where('transaction_status', 'waiting')->first();
            if ($wallet) {
                $wallet->transaction_status = 'received';
                $wallet->transaction_id = $request->transaction_id;
                $wallet->transaction_date = Carbon::now();
                $wallet->transaction_balance = $balance;
                $wallet->save();

                try {
                    $this->sendWithdrawCompletedSms(
                        $user,
                        $balance,
                        $request->transaction_id,
                        $wallet->payment_type ?? 'Bkash',
                        $wallet->transaction_date
                    );
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error('Withdraw completion SMS failed', [
                        'user_id' => $user->id,
                        'wallet_id' => $wallet->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Payment successful');
        } else {
            return redirect()->back()->with('error', 'Insufficient balance');
        }
    }
    
     public function varifiedAccount()
    {
        $data['wallets'] = Wallet::select('wallets.id', 'wallets.user_id', 'wallets.mobile_no', 'wallets.payment_type', 'wallets.transaction_status', 'profile_verifies.nid_no', 'users.name', 'users.balance', 'profile_verifies.front_image', 'profile_verifies.back_image')->join('users', 'wallets.user_id', '=', 'users.id')->leftJoin('profile_verifies', 'profile_verifies.user_id', '=', 'users.id')->get();
        return view('backend.wallets.varified-account', $data);
    }
}
