<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerImage extends Model
{
    use HasFactory;
    protected $fillable = ['banner_small_image_one','banner_small_image_two','category_banner_image','shop_page_banner'];
}
