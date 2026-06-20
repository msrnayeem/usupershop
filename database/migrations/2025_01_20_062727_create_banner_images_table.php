<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_images', function (Blueprint $table) {
            $table->id();
            $table->string('banner_small_image_one')->nullable();
            $table->string('banner_small_image_two')->nullable();
            $table->string('offer_banner_image_one')->nullable();
            $table->string('offer_banner_image_two')->nullable();
            $table->string('deals_banner_image_one')->nullable();
            $table->string('deals_banner_image_two')->nullable();
            $table->string('featured_banner_image_one')->nullable();
            $table->string('featured_banner_image_two')->nullable();
            $table->string('category_banner_image')->nullable();
            $table->string('bestseller_banner_image_one')->nullable();
            $table->string('bestseller_banner_image_two')->nullable();
            $table->string('shop_page_banner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_images');
    }
}
