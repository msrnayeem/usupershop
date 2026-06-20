<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'referral_no',
        'seller_type',
        'transction_mode',
        'subscription_fee',
        'date',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }
}
