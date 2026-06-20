<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShipmentToOrderStatusEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','canceled','packaging','shipment','delivered','return') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','canceled','packaging','delivered','return') NOT NULL DEFAULT 'pending'");
    }
}
