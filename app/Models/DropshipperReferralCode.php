<?php

// App/Models/DropshipperReferralCode.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshipperReferralCode extends Model
{
    protected $fillable = [
        'dropshipper_id', 
        'referral_code', 
        'is_active'
    ];

    public function dropshipper()
    {
        return $this->belongsTo(User::class, 'dropshipper_id');
    }

    public static function generateUniqueCode($dropshipperId)
    {
        do {
            $code = 'REF' . $dropshipperId . strtoupper(substr(uniqid(), -6));
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }
}