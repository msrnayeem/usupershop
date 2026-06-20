<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['client_id','order_id','transaction_type','payment_method',
    'credit','debit','order_note','status','trxID'];
}
