<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerFee extends Model
{
    use HasFactory;
    protected $fillable = ['account_type_of_myshop', 'subscription_fees', 'duration', 'plan_features'];

    protected $casts = [
        'plan_features' => 'array',
    ];
}
