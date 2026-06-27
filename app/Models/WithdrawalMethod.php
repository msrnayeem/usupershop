<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WithdrawalMethod extends Model
{
    use HasFactory;

    protected $table = 'withdrawal_methods';

    protected $fillable = [
        'name', 'logo_emoji', 'logo_color', 'account_label',
        'account_placeholder', 'account_regex', 'is_active',
        'sort_order', 'instructions',
    ];
}
