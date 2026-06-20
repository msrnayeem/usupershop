<?php
namespace App\Traits;

use App\Models\Transaction;
use App\Models\User;
use App\utilities\Constant;
use Helper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

trait ReferCommissionTrait {

    public function distribute_refer_commission($user, $amount) {
        $user_id = $user->id;
        Log::info("ReferCommissionTrait: Start distributing commission", [
            'user_id' => $user_id,
            'amount' => $amount
        ]);

        if ($amount < 1) {
            Log::error("ReferCommissionTrait: Invalid commission amount", [
                'message' => 'Amount cannot be less than 1',
                'amount' => $amount
            ]);
            return [
                'status' => false,
                'message' => 'Amount cannot be less than 1'
            ];
        }

        $siteSetting = Helper::get_setting_data();
        if (!$siteSetting) {
            Log::error("ReferCommissionTrait: Site setting data not found");
            return [
                'status' => false,
                'message' => 'Site setting data not found'
            ];
        }

        $referrer = User::where('id', $user_id)->first();
        if (!$referrer) {
            Log::error("ReferCommissionTrait: User not found", ['referrer' => $user_id]);
            return [
                'status' => false,
                'message' => 'referrer not found'
            ];
        }

        Log::info("referrer found", [
            'referrer' => $referrer->id,
            'status' => $referrer->status,
            'payment_status' => $referrer->payment_status
        ]);

        if ($referrer->status != 1) {
            Log::error("ReferCommissionTrait: referrer is inactive", ['referrer' => $referrer->id]);
            return [
                'status' => false,
                'message' => 'referrer is inactive'
            ];
        }

        if ($referrer->payment_status != 1) {
            Log::error("ReferCommissionTrait: referrer payment status is unpaid", ['referrer' => $referrer->id]);
            return [
                'status' => false,
                'message' => 'referrer payment status is unpaid'
            ];
        }

        $commission_amount = Helper::percentage_amount(
            ($siteSetting->refer_commission ?? 0),
            ($siteSetting->refer_commission_type ?? 0),
            $amount
        );

        $referrer->refer_commission += $commission_amount;
        $referrer->balance += $commission_amount;
        $referrer->save();

        $tnx_note = '';
        if($user->usertype === 'vendor'){
            $tnx_note = 'Refer Commission From ' . $user->name. ' ('.$user->refer_code.')';
        }
        if($user->usertype === 'seller'){
            $tnx_note = 'Refer Commission From ' . $user->name. ' ('.$user->refer_code.')';
        }

        Transaction::create([
            'user_id' => $referrer->id,
            'from_user_id' => $user->id,
            'wallet_type' => Constant::WALLET_TYPE['balance_wallet'],
            'tnx_type' => Constant::TRANSACTION_TYPE['refer_commission'],
            'credit' => $commission_amount,
            'debit' => 0,
            'note' => $tnx_note,
            'status' => Constant::STATUS['approved'],
            'in_status' => Constant::IN_STATUS['active'],
            'date' => time(),
        ]);

        return true;
    }

}
