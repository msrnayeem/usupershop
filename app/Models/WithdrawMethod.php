<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawMethod extends Model
{
    protected $table    = 'withdraw_methods';
    protected $fillable = ['name','logo_icon','color','number_label','number_placeholder','is_active','sort_order'];

    public static function active()
    {
        return self::where('is_active', 1)->orderBy('sort_order')->get();
    }
}
