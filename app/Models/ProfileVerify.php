<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileVerify extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','nid_no','birthdate','front_image','back_image'];
    public function users(){
        return $this->belongsTo(User::class,'id','user_id');
    }
}
