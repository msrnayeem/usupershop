<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method',
        'transaction_no',
    ];

    /**
     * Readable payment method label
     */
    public function getMethodLabelAttribute(): string
    {
        return match (strtolower($this->payment_method ?? '')) {
            'bkash', 'b-kash' => 'bKash',
            'cod'              => 'Cash on Delivery',
            'eps'              => 'EPS',
            default            => ucfirst($this->payment_method ?? 'N/A'),
        };
    }
}
