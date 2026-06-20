<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['address','mobile','email','facebook','facebook_icon','youtube','youtube_icon',
    'twitter','twitter_icon','instagram','instagram_icon','telegram','telegram_icon','whatsapp','whatsapp_icon'];
}
