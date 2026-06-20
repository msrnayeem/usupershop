<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class PaymentGateway extends Model
{
    use HasFactory;
    protected $fillable = ['BKASH_USERNAME','active_status','BKASH_PASSWORD','BKASH_API_KEY','BKASH_SECRET_KEY',
    'NAGAD_USERNAME','NAGAD_PASSWORD','NAGAD_API_KEY','NAGAD_SECRET_KEY'];
}
