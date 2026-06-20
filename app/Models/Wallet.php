<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','mobile_no','payment_type','transaction_status',
    'transaction_id',
    'transaction_date',
    'transaction_balance'];
}