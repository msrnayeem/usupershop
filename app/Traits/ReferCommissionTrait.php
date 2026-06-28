<?php
namespace App\Traits;

use App\Models\Transaction;
use App\Models\User;
use App\Utilities\Constant;
use Helper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

trait ReferCommissionTrait {

    public function distribute_refer_commission($newUser, $amount) {
        // $newUser = যে নতুন account তৈরি করেছে
        // referrer = যার refer code ব্যবহার করেছে (reseller_id দিয়ে খুঁজি)

        if (!$newUser->reseller_id) {
            Log::info("ReferCommissionTrait: No reseller_id on new user", ['user_id' => $newUser->id]);
            return ['status' => false, 'message' => 'No referrer found'];
        }

        $referrer = User::find($newUser->reseller_id);
        if (!$referrer) {
            Log::error("ReferCommissionTrait: Referrer not found", ['reseller_id' => $newUser->reseller_id]);
            return ['status' => false, 'message' => 'Referrer not found'];
        }

        Log::info("ReferCommissionTrait: Start distributing commission", [
            'new_user_id'  => $newUser->id,
            'referrer_id'  => $referrer->id,
            'amount'       => $amount
        ]);

        if ($referrer->status != 1) {
            Log::error("ReferCommissionTrait: referrer is inactive", ['referrer' => $referrer->id]);
            return ['status' => false, 'message' => 'Referrer is inactive'];
        }

        if ($referrer->payment_status != 1) {
            Log::error("ReferCommissionTrait: referrer payment unpaid", ['referrer' => $referrer->id]);
            return ['status' => false, 'message' => 'Referrer payment status is unpaid'];
        }

        $siteSetting = \Helper::get_setting_data();
        if (!$siteSetting) {
            return ['status' => false, 'message' => 'Site setting not found'];
        }

        $commission_amount = \Helper::percentage_amount(
            ($siteSetting->refer_commission ?? 0),
            ($siteSetting->refer_commission_type ?? 0),
            $amount
        );

        // If commission is 0 or flat ৳200 not set, use default ৳200
        if ($commission_amount <= 0) {
            $commission_amount = 200;
        }

        $referrer->refer_commission = ($referrer->refer_commission ?? 0) + $commission_amount;
        $referrer->balance          = ($referrer->balance ?? 0) + $commission_amount;
        $referrer->save();

        $tnx_note = 'Refer Commission From ' . $newUser->name . ' (' . $newUser->refer_code . ')';

        Transaction::create([
            'user_id'      => $referrer->id,
            'from_user_id' => $newUser->id,
            'wallet_type'  => Constant::WALLET_TYPE['balance_wallet'],
            'tnx_type'     => Constant::TRANSACTION_TYPE['refer_commission'],
            'credit'       => $commission_amount,
            'debit'        => 0,
            'note'         => $tnx_note,
            'status'       => Constant::STATUS['approved'],
            'in_status'    => Constant::IN_STATUS['active'],
            'date'         => time(),
        ]);

        Log::info("ReferCommissionTrait: Commission distributed", [
            'referrer_id'  => $referrer->id,
            'new_user_id'  => $newUser->id,
            'commission'   => $commission_amount,
        ]);

        return true;
    }

}
