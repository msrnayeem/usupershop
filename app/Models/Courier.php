<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = [
        'name', 'client_id', 'client_secret', 'api_key', 'store_id', 'is_active'
    ];
}

